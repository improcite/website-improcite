<nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary shadow container" data-bs-theme="dark">
  <div class="container-fluid fw-bold">
    <a class="navbar-brand" href="/"><img src="/assets/images/favicon-improcite-fond.png"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/"><i class="fas fa-home me-1"></i> Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/?p=agenda"><i class="fas fa-calendar me-1"></i> Agenda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/?p=equipe"><i class="fas fa-users me-1"></i> Équipe</a>
        </li>
        {if $display_recrutement_public}
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/?p=recrutement"><i class="fas fa-handshake me-1"></i> Recrutement</a>
        </li>
        {/if}
      </ul>
      <ul class="navbar-nav navbar-right">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="https://www.facebook.com/improcite" target="_blank"><i class="fa-brands fa-square-facebook"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://www.instagram.com/improcite/" target="_blank"><i class="fa-brands fa-square-instagram"></i></a>
        </li>
      </ul>
    </div>
  </div>
</nav>
