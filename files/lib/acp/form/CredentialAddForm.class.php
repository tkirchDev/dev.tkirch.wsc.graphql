<?php
namespace graphql\acp\form;

use graphql\data\credential\CredentialAction;
use graphql\data\credential\CredentialList;
use graphql\data\permission\PermissionList;
use wcf\form\AbstractFormBuilderForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\field\MultipleSelectionFormField;
use wcf\system\form\builder\field\TextFormField;
use wcf\system\form\builder\field\validation\FormFieldValidationError;
use wcf\system\form\builder\field\validation\FormFieldValidator;

class CredentialAddForm extends AbstractFormBuilderForm
{

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'graphql.acp.menu.link.credential.list';

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.graphql.canManageCredential'];

    /**
     * @inheritDoc
     */
    public $formAction = 'create';

    /**
     * @inheritDoc
     */
    public $objectActionClass = CredentialAction::class;

    /**
     * @inheritDoc
     */
    protected function createForm()
    {
        parent::createForm();

        $this->form->appendChildren([
            FormContainer::create('general')
                ->label('graphql.credential.general')
                ->appendChildren([
                    TextFormField::create('name')
                        ->label('graphql.credential.name')
                        ->required()
                        ->maximumLength(255),
                    TextFormField::create('credentialKey')
                        ->label('graphql.credential.key')
                        ->required()
                        ->value(bin2hex(random_bytes(8)))
                        ->maximumLength(255)
                        ->addValidator(new FormFieldValidator('credentialKey', function (TextFormField $formField) {
                            if ($formField->getValue()) {
                                $credentialList = new CredentialList();
                                $credentialList->readObjects();
                                $credentialKeyList = array_column($credentialList->getObjects(), 'credentialKey');

                                if (in_array($formField->getValue(), $credentialKeyList)) {
                                    $formField->addValidationError(
                                        new FormFieldValidationError(
                                            'credentialKey',
                                            'graphql.credential.key.error.alreadyExists'
                                        )
                                    );
                                }
                            }
                        })),
                    TextFormField::create('secret')
                        ->label('graphql.credential.secret')
                        ->description('graphql.credential.secret.description')
                        ->value(bin2hex(random_bytes(64)))
                        ->required(),
                ]),
            FormContainer::create('other')
                ->label('graphql.credential.other')
                ->appendChildren([
                    MultipleSelectionFormField::create('permissions')
                        ->label('graphql.credential.permissions')
                        ->options(new PermissionList()),
                ]),
        ]);
    }
}
