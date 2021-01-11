{include file='header' pageTitle='graphql.acp.menu.link.credential.list'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}graphql.acp.menu.link.credential.list{/lang} <span class="badge">{#$items}</span></h1>
	</div>

	<nav class="contentHeaderNavigation">
		<ul>
			<li><a href="{link application='graphql' controller='CredentialAdd'}{/link}" class="button"><span class="icon icon16 fa-plus"></span> <span>{lang}graphql.acp.menu.link.credential.add{/lang}</span></a></li>
            
			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

{hascontent}
	<div class="paginationTop">
		{content}{pages print=true assign=pagesLinks application='graphql' controller='CredentialList' link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}{/content}
	</div>
{/hascontent}

{if $objects|count}
	<div class="section tabularBox" id="credentialTableContainer">
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnCredentialID{if $sortField == 'name'} active {@$sortOrder}{/if}" colspan="2"><a href="{link application='graphql' controller='CredentialList'}pageNo={@$pageNo}&sortField=credentialID&sortOrder={if $sortField == 'credentialID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle columnName{if $sortField == 'name'} active {@$sortOrder}{/if}"><a href="{link application='graphql' controller='CredentialList'}pageNo={@$pageNo}&sortField=name&sortOrder={if $sortField == 'name' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}graphql.credential.name{/lang}</a></th>
					
					{event name='columnHeads'}
				</tr>
			</thead>

			<tbody>
				{foreach from=$objects item=credential}
					<tr class="jsCredentialRow">
   						<td class="columnIcon">
   							<a href="{link application='graphql' controller='Credential' object=$credential}{/link}" title="{lang}graphql.credential.view{/lang}" class="jsTooltip"><span class="icon icon16 fa-search"></span></a>
   							<span class="icon icon16 fa-times jsDeleteButton jsTooltip pointer" title="{lang}wcf.global.button.delete{/lang}" data-object-id="{@$credential->credentialID}" data-confirm-message-html="{lang __encode=true}graphql.credential.delete.confirmMessage{/lang}"></span>

   							{event name='rowButtons'}
   						</td>
						<td class="columnID columnCredentialID">
							{$credential->credentialID}
						</td>
						<td class="columnTitle columnName">
							<a href="{link application='graphql' controller='Credential' object=$credential}{/link}">
								{$credential->getTitle()}
							</a>
						</td>

						{event name='columns'}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>

	<footer class="contentFooter">
		{hascontent}
			<div class="paginationBottom">
				{content}{@$pagesLinks}{/content}
			</div>
		{/hascontent}
	</footer>
{else}
	<p class="info">{lang}wcf.global.noItems{/lang}</p>
{/if}

<script data-relocate="true">
	$(function() {
		new WCF.Action.Delete('graphql\\data\\credential\\CredentialAction', '.jsCredentialRow');

		var options = { };
		{if $pages > 1}
			options.refreshPage = true;
			{if $pages == $pageNo}
				options.updatePageNumber = -1;
			{/if}
		{else}
			options.emptyMessage = '{lang}wcf.global.noItems{/lang}';
		{/if}

		new WCF.Table.EmptyTableHandler($('#credentialTableContainer'), 'jsCredentialRow', options);
	});
</script>

{include file='footer'}