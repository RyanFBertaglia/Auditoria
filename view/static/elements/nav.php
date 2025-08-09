<?php
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
?>
<nav class="topbar">
  <div class="topbar-inner">
    <div class="nav-left">
      <a href="/">Página Inicial</a>
      <a href="/posts">Postagens</a>
      <?php if (!isset($_SESSION['admin'])): ?>
      <a href="/reclamar">Postar</a>
      <?php endif; ?>
    </div>

    <div class="nav-right">
      <?php if (isset($_SESSION['logado'])): ?>
        <a class="account" href="/minha-conta" title="Minha conta" aria-label="Minha conta">
          <svg class="icon avatar" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
            <circle cx="12" cy="8" r="3.2" />
            <path d="M4 20c0-3.3 4.3-5 8-5s8 1.7 8 5" />
          </svg>
          <span>Minha conta</span>
        </a>

        <a class="logout" href="/logout" title="Logout" aria-label="Logout">
          <svg class="icon logout-icon" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
            <path d="M16 13v-2H7V8l-5 4 5 4v-3z" />
            <path d="M20 3H11v2h9v14h-9v2h9a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/>
          </svg>
          <span>Logout</span>
        </a>
      <?php else: ?>
        <a class="login" href="/login">Entrar</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<style>

  * { box-sizing: border-box; }
  :root {
    --bg: #4a6fa5;
    --accent: #daa21b;
    --text: #ffffff;
    --muted: rgba(255,255,255,0.85);
  }

  .topbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: linear-gradient(180deg, rgba(74,111,165,0.98), var(--bg));
    border-bottom: 1px solid rgba(0,0,0,0.08);
    z-index: 999;
    backdrop-filter: blur(6px);
  }

  .topbar-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
  }

  .nav-left,
  .nav-right {
    display: flex;
    align-items: center;
    gap: 20px;
  }

  .nav-left a {
    color: var(--text);
    text-decoration: none;
    font-weight: 500;
    padding: 8px 12px;
    border-radius: 6px;
    transition: background-color .18s, color .18s, transform .06s;
    position: relative;
    font-size: 15px;
  }

  .nav-left a::after {
    content: "";
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: -12px;
    width: 0;
    height: 2px;
    background: var(--accent);
    transition: width .22s;
  }

  .nav-left a:hover {
    background: rgba(255,255,255,0.06);
    color: var(--accent);
  }
  .nav-left a:hover::after { width: 100%; }

  .nav-right a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--text);
    text-decoration: none;
    padding: 8px 10px;
    border-radius: 8px;
    font-weight: 500;
    transition: background-color .15s, transform .08s;
    font-size: 14px;
  }

  .nav-right a:hover {
    background: rgba(255,255,255,0.06);
    color: var(--accent);
  }

  .icon { fill: none; stroke: var(--text); stroke-width: 1.4; stroke-linecap: round; stroke-linejoin: round; }
  .avatar { stroke-width: 1.6; }
  .logout-icon { stroke-width: 1.6; transform: translateY(1px); }

  .logout {
    background: rgba(255,255,255,0.03);
  }


  body { padding-top: 64px; }
</style>
