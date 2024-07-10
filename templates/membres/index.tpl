{include file="header.tpl"}

<div class="col-12 col-sm-3 col-xl-2 px-sm-2 px-0 bg-dark d-flex sticky-top">
{include file="menu.tpl"}
</div>

<div class="col d-flex flex-column h-sm-100">
  <main class="row overflow-auto">
    <div class="col pt-4">
    {include file="{$p}.tpl"}
    </div>
  </main>

{include file="footer.tpl"}
