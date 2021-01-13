{include file='header' pageTitle='graphql.acp.menu.link.credential'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}graphql.acp.menu.link.credential{/lang}: {$credential->getTitle()}</h1>
	</div>

	<nav class="contentHeaderNavigation">
		<ul>
			<li><a href="{link application='graphql' controller='CredentialList'}{/link}" class="button"><span class="icon icon16 fa-list"></span> <span>{lang}graphql.acp.menu.link.credential.list{/lang}</span></a></li>
            
			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

<div class="section">
    <h1 class="sectionTitle">{lang}graphql.credential.details{/lang}</h1>
    <dl class="plain dataList">
        <dt>{lang}graphql.credential.name{/lang}</dt>
        <dd>{$credential->getTitle()}</dd>
        <dt>{lang}graphql.credential.key{/lang}</dt>
        <dd>{$credential->key}</dd>
	</dl>
</div>

<div class="section">
    <h1 class="sectionTitle">{lang}graphql.credential.permissions{/lang}</h1>
</div>

<div class="section">
    <h1 class="sectionTitle">{lang}graphql.credential.tokens{/lang}</h1>
    {if $credential->getTokens()|count}
        <div class="section tabularBox" id="tokenTableContainer">
            <table class="table">
                <thead>
                    <tr>
                        <th class="columnID columnTokenID">{lang}wcf.global.objectID{/lang}</th>
                        <th class="columnTitle columnType">{lang}graphql.credential.token.type{/lang}</th>
                        <th class="columnTitle columnValidUntil">{lang}graphql.credential.token.validUntil{/lang}</th>
                        <th class="columnTitle columnCreatedAt">{lang}graphql.credential.token.createdAt{/lang}</th>
                        
                        {event name='columnHeads'}
                    </tr>
                </thead>

                <tbody>
                    {foreach from=$credential->getTokens() item=token}
                        <tr class="jsTokenRow">
                            <td class="columnID columnTokenID">
                                {$token->credentialTokenID}
                            </td>
                            <td class="columnTitle columnType">
                                {lang}graphql.credential.token.type.{$token->type}{/lang}
                            </td>
                            <td class="columnTitle columnValidUntil">
                                {@$token->validUntil|time}
                            </td>
                            <td class="columnTitle columnCreatedAt">
                                {@$token->createdAt|time}
                            </td>

                            {event name='columns'}
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    {else}
        <p class="info">{lang}wcf.global.noItems{/lang}</p>
    {/if}
</div>

{include file='footer'}