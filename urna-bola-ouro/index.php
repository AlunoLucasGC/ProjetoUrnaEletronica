<?php
// ============================================================
// URNA BOLA DE OURO - Tela principal
// Nesta primeira versão, os candidatos estão em um array de exemplo.
// Depois, você poderá buscar esses dados diretamente do MySQL.
// ============================================================

include 'conexao.php';

function buscarCandidato($pdo){
    $sql = "SELECT numero, nome, time, foto FROM candidatos";
    
    $consulta = $pdo->query($sql);
    $candidatos = $consulta->fetchAll();

    return $candidatos;
    
    }

    $pdo = conectarBanco();
    $candidatos = buscarCandidato($pdo);

?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Urna Bola de Ouro</title>

    <!-- Bootstrap 5.3.8 via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <div class="brand-mark">🏆</div>
            <div>
                <p class="eyebrow mb-1">VOTAÇÃO POPULAR</p>
                <h1 class="brand-title mb-0">Bola de Ouro <span>2026</span></h1>
            </div>
            <div class="topbar-tag ms-auto d-none d-md-flex">
                <span class="live-dot"></span>
                SIMULAÇÃO DE VOTAÇÃO
            </div>
        </header>

        <main class="row g-4 align-items-stretch">
            <!-- COLUNA ESQUERDA: CANDIDATOS -->
            <aside class="col-12 col-lg-3">
                <section class="surface-card h-100 candidate-panel">
                    <div class="section-heading">
                        <div>
                            <p class="eyebrow mb-1">A DISPUTA</p>
                            <h2 class="panel-title">Candidatos</h2>
                        </div>
                        <span class="count-pill"><?= count($candidatos) ?></span>
                    </div>

                    <p class="muted-copy">Selecione um jogador ou digite seu número na urna.</p>

                    <div class="candidate-list" id="listaCandidatos">
                        <?php foreach ($candidatos as $candidato): ?>
                            <button type="button"
                                    class="candidate-option"
                                    data-numero="<?= htmlspecialchars($candidato['numero']) ?>"
                                    data-nome="<?= htmlspecialchars($candidato['nome']) ?>"
                                    data-time="<?= htmlspecialchars($candidato['time']) ?>"
                                    data-foto="<?= htmlspecialchars($candidato['foto']) ?>">
                                <span class="candidate-avatar">
                                    <img src="assets/img/<?= htmlspecialchars($candidato['foto']) ?>"
                                         alt="Foto de <?= htmlspecialchars($candidato['nome']) ?>"
                                         onerror="this.style.display='none'; this.parentElement.classList.add('avatar-fallback');">
                                </span>
                                <span class="candidate-copy">
                                    <strong><?= htmlspecialchars($candidato['nome']) ?></strong>
                                    <small><?= htmlspecialchars($candidato['time']) ?></small>
                                </span>
                                <span class="candidate-number"><?= htmlspecialchars($candidato['numero']) ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <div class="candidate-hint mt-4">
                        <span class="hint-icon">i</span>
                        <p class="mb-0">Os números dos candidatos possuem dois dígitos. Clique em um nome para preencher a urna.</p>
                    </div>
                </section>
            </aside>

            <!-- COLUNA CENTRAL: URNA -->
            <section class="col-12 col-lg-6">
                <div class="urna-card">
                    <div class="urna-heading">
                        <div>
                            <p class="eyebrow mb-1">SISTEMA DE VOTAÇÃO</p>
                            <h2 class="panel-title mb-0">Sua escolha</h2>
                        </div>
                        <span class="secure-label"><span>●</span> URNA DIGITAL</span>
                    </div>

                    <form id="urnaForm" action="registrar-voto.php" method="POST" autocomplete="off">
                        <input type="hidden" name="numero" id="numeroVoto" value="">

                        <div class="urna-body">
                            <div class="screen-frame">
                                <div class="screen" id="tela">
                                    <div class="screen-topline">
                                        <span>JUSTIÇA ELEITORAL</span>
                                        <span class="screen-led"></span>
                                    </div>

                                    <div class="screen-main" id="telaVoto">
                                        <div class="screen-info">
                                            <p class="screen-kicker">SEU VOTO PARA</p>
                                            <h3>MELHOR DO MUNDO</h3>

                                            <div class="number-area">
                                                <span>NÚMERO:</span>
                                                <div class="number-boxes">
                                                    <span class="number-digit" id="digito1"></span>
                                                    <span class="number-digit" id="digito2"></span>
                                                </div>
                                            </div>

                                            <div class="candidate-data" id="infoCandidato">
                                                <p><b>NOME:</b> <span id="nome">—</span></p>
                                                <p><b>TIME:</b> <span id="time">—</span></p>
                                            </div>
                                            <p class="screen-message" id="aviso">Digite o número do seu candidato.</p>
                                        </div>

                                        <div class="screen-photo" id="fotoBox">
                                            <img id="foto" src="" alt="Foto do candidato">
                                            <span>SEU CANDIDATO</span>
                                        </div>
                                    </div>

                                    <div class="screen-footer">
                                        <span>VERDE <b>CONFIRMA</b></span>
                                        <span>LARANJA <b>CORRIGE</b></span>
                                    </div>
                                </div>
                            </div>

                            <div class="keyboard-area">
                                <div class="keyboard-brand">
                                    <div class="keyboard-emblem">⚖</div>
                                    <div><strong>TRIBUNAL</strong><small>DA VOTAÇÃO</small></div>
                                </div>

                                <div class="number-pad" id="teclasNumericas">
                                    <?php for ($i = 1; $i <= 9; $i++): ?>
                                        <button type="button" class="number-key" data-numero="<?= $i ?>"><?= $i ?></button>
                                    <?php endfor; ?>
                                    <button type="button" class="number-key zero-key" data-numero="0">0</button>
                                </div>

                                <div class="action-keys">
                                    <button type="button" class="action-key blank-key" id="btnBranco">BRANCO</button>
                                    <button type="button" class="action-key correct-key" id="btnCorrige">CORRIGE</button>
                                    <button type="submit" class="action-key confirm-key" id="btnConfirma">CONFIRMA</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="keyboard-help">
                        <span><kbd>0–9</kbd> Digitar</span>
                        <span><kbd>Enter</kbd> Confirmar</span>
                        <span><kbd>Backspace</kbd> Corrigir</span>
                        <span><kbd>B</kbd> Branco</span>
                    </div>
                </div>
            </section>

            <!-- COLUNA DIREITA: PAINEL -->
            <aside class="col-12 col-lg-3">
                <section class="surface-card h-100 side-panel">
                    <p class="eyebrow mb-1">ACOMPANHAMENTO</p>
                    <h2 class="panel-title">Painel da votação</h2>

                    <div class="simulation-box">
                        <div class="simulation-icon">✦</div>
                        <div>
                            <strong>Regra especial da simulação</strong>
                            <p class="mb-0">A cada 2 votos em outros candidatos, Harry Kane recebe 3 votos bônus automáticos.</p>
                        </div>
                    </div>

                    <div class="side-actions">
                        <a class="btn btn-outline-light w-100" href="resultado.php">📊 Ver resultado</a>
                        <form action="zerar-votacao.php" method="POST" id="formZerar">
                            <button type="submit" class="btn btn-outline-danger w-100">↻ Zerar votação</button>
                        </form>
                    </div>

                    <div class="side-note">
                        <span class="note-line"></span>
                        <p>Projeto acadêmico demonstrativo. Os votos bônus são identificados separadamente no banco de dados.</p>
                    </div>
                </section>
            </aside>
        </main>

        <footer class="page-footer">
            <span>URNA BOLA DE OURO</span>
            <span>Projeto de estudo • PHP + MySQL + Bootstrap</span>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwxH9j09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
    <script src="assets/js/urna.js"></script>
</body>
</html>
