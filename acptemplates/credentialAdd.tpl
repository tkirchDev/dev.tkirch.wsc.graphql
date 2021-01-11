{include file='header' pageTitle='graphql.acp.menu.link.credential'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}graphql.acp.menu.link.credential{/lang}</h1>
	</div>

	<nav class="contentHeaderNavigation">
		<ul>
			<li><a href="{link application='graphql' controller='CredentialList'}{/link}" class="button"><span class="icon icon16 fa-list"></span> <span>{lang}graphql.acp.menu.link.credential.list{/lang}</span></a></li>
			
			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

{@$form->getHtml()}

{include file='footer'}