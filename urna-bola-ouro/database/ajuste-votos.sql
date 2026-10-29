-- Execute uma única vez no banco urna_eletronica.
-- NÃO execute novamente o script que contém DROP DATABASE se quiser preservar seus dados.

ALTER TABLE votos
ADD COLUMN tipo ENUM('REAL', 'BONUS') NOT NULL DEFAULT 'REAL';

-- Opcional: atualize o nome mostrado para o candidato de número 09.
UPDATE candidatos
SET nome = 'Harry Kane'
WHERE numero = '09';
