URNA BOLA DE OURO - PROJETO INICIAL
==================================

Tecnologias
- PHP
- MySQL
- Bootstrap 5.3.8
- JavaScript (somente para controlar a interação da tela/teclado)

ESTRUTURA
index.php                  Tela principal da urna
conexao.php                Base da função de conexão PDO
registrar-voto.php         Base da função de registro de votos
resultado.php              Base da apuração
zerar-votacao.php          Base para apagar os votos
assets/css/style.css       Estilos próprios
assets/js/urna.js          Teclado, seleção de candidato e tela
assets/img/                Coloque aqui as fotos dos candidatos
 database/ajuste-votos.sql Alteração necessária na tabela votos

COMO ABRIR
1. Coloque a pasta urna-bola-ouro dentro da pasta do servidor local.
   Exemplo no XAMPP: C:\xampp\htdocs\urna-bola-ouro
2. Inicie Apache e MySQL.
3. Confira se o banco urna_eletronica e as tabelas candidatos e votos existem.
4. Execute database/ajuste-votos.sql uma única vez.
5. Copie as fotos para assets/img, usando os nomes:
   Messi.webp, yamal.webp, kane.jfif e Mbappe.webp
6. Acesse http://localhost/urna-bola-ouro/

ATENÇÃO
As funções PHP de conexão, registro, resultado e zerar votação estão incompletas de propósito,
conforme solicitado. A interface funciona no navegador, mas os votos não serão gravados até
você implementar os trechos marcados com TODO.

LÓGICA DA REGRA ESPECIAL (simulação)
- O número 09 identifica Harry Kane.
- Somente votos REAL para outros candidatos entram na contagem que gera bônus.
- A cada 2 votos REAL de outros candidatos, devem existir 3 votos BONUS para o número 09.
- A tabela votos possui a coluna tipo para separar REAL de BONUS.
- Votos em branco, nulos e votos reais em Harry Kane não geram bônus.

Uma forma de calcular a meta de bônus:
    metaBonus = intdiv(totalVotosReaisDosOutrosCandidatos, 2) * 3;

Depois compare a metaBonus com a quantidade de votos BONUS já gravados para o número 09.
Insira apenas a diferença. Assim, os bônus não são duplicados a cada novo voto.

IMPORTANTE SOBRE O SQL ORIGINAL
O script inicial enviado contém DROP DATABASE IF EXISTS. Isso apaga e recria o banco.
Se já existem votos ou dados que deseja preservar, NÃO execute esse script novamente.
Execute apenas database/ajuste-votos.sql para acrescentar a coluna tipo.
