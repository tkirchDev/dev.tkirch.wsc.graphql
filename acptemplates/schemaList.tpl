{include file='header' pageTitle='graphql.acp.menu.link.schema.list'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}graphql.acp.menu.link.schema.list{/lang} <span class="badge">{#$items}</span></h1>
	</div>

	<nav class="contentHeaderNavigation">
		<ul>
			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

{hascontent}
	<div class="paginationTop">
		{content}{pages print=true assign=pagesLinks application='graphql' controller='SchemaList' link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}{/content}
	</div>
{/hascontent}

{if $objects|count}
	<div class="section tabularBox" id="schemaTableContainer">
		<table class="table">
			<thead>
				<tr>
					<th class="columnTitle columnName{if $sortField == 'name'} active {@$sortOrder}{/if}"><a href="{link application='graphql' controller='SchemaList'}pageNo={@$pageNo}&sortField=name&sortOrder={if $sortField == 'name' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}graphql.schema.name{/lang}</a></th>
					<th class="columnTitle columnFilepath">{lang}graphql.schema.filepath{/lang}</th>
					<th class="columnTitle columnPriority{if $sortField == 'priority'} active {@$sortOrder}{/if}"><a href="{link application='graphql' controller='SchemaList'}pageNo={@$pageNo}&sortField=priority&sortOrder={if $sortField == 'priority' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}graphql.schema.priority{/lang}</a></th>
					
					{event name='columnHeads'}
				</tr>
			</thead>

			<tbody>
				{foreach from=$objects item=schema}
					<tr class="jsSchemaRow">
						<td class="columnTitle columnName">{$schema->name}</td>
						<td class="columnTitle columnFilepath">{$schema->filepath}</td>
						<td class="columnTitle columnPriority">{$schema->priority}</td>

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
		new WCF.Action.Delete('graphql\\data\\schema\\SchemaAction', '.jsSchemaRow');

		var options = { };
		{if $pages > 1}
			options.refreshPage = true;
			{if $pages == $pageNo}
				options.updatePageNumber = -1;
			{/if}
		{else}
			options.emptyMessage = '{lang}wcf.global.noItems{/lang}';
		{/if}

		new WCF.Table.EmptyTableHandler($('#schemaTableContainer'), 'jsSchemaRow', options);
	});
</script>

{include file='footer'}