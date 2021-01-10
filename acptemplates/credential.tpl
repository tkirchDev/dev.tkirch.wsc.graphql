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
    <h1 class="sectionTitle">{lang}graphql.credential.tokens{/lang}</h1>
</div>


{include file='footer'}