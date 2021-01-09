{include file='header' pageTitle='graphql.acp.menu.link.schema'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}graphql.acp.menu.link.schema{/lang}: {$schema->getTitle()}</h1>
	</div>

	<nav class="contentHeaderNavigation">
		<ul>
			<li><a href="{link application='graphql' controller='SchemaList'}{/link}" class="button"><span class="icon icon16 fa-list"></span> <span>{lang}graphql.acp.menu.link.schema.list{/lang}</span></a></li>
			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

<div class="section">
    <h1 class="sectionTitle">{lang}graphql.schema.details{/lang}</h1>
    <dl class="plain dataList">
        <dt>{lang}graphql.schema.name{/lang}</dt>
        <dd>{$schema->getTitle()}</dd>
        <dt>{lang}graphql.schema.priority{/lang}</dt>
        <dd>{$schema->priority}</dd>
        <dt>{lang}graphql.schema.filepath{/lang}</dt>
        <dd>{$schema->filepath}</dd>
	</dl>
</div>

<div class="section">
    <h1 class="sectionTitle">{lang}graphql.schema.fileContent{/lang}</h1>
    <pre>{$schema->getFileContent()}</pre>
</div>


{include file='footer'}