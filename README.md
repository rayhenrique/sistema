# KL PDV - Sistema de Gestao Comercial

Aplicacao Laravel 12 + Tailwind 4 criada para pequenas e medias empresas controlarem pedidos, estoque e recebiveis em um unico painel.

## Recursos principais

- Geracao de pedidos com itens, descontos e impressao em A4 ou cupom nao fiscal.
- Cadastro completo de clientes, fornecedores e produtos (com estoque minimo, custo, margem e fornecedor).
- Controle de estoque em tempo real com historico de movimentacoes de entrada/saida e alertas de reposicao.
- Status de remessa, forma de pagamento e contas a receber (PIX, boleto, promissoria, cartao, cheque etc.).
- Dashboard com indicadores financeiros, pedidos recentes, clientes destaque e alertas de estoque baixo.
- Perfis de usuario (administrador, gerente, vendedor) prontos para integrar com autenticao Laravel.

## Stack

| Camada        | Tecnologia            |
| ------------- | -------------------- |
| Backend       | PHP 8.3 + Laravel 12 |
| Frontend      | Vite + Tailwind 4    |
| Banco de dados| MySQL 8 (XAMPP)      |

## Configuracao rapida

```bash
cp .env.example .env      # ajuste DB_* e APP_TIMEZONE
composer install
npm install
php artisan key:generate
php artisan migrate --seed
npm run dev               # ou npm run build
php artisan serve         # ou Apache/Nginx
```

Credenciais criadas pelo seed:

| Perfil        | Login               | Senha    |
| ------------- | ------------------- | -------- |
| Administrador | admin@klpdv.local   | klpdv123 |
| Gerente       | gerente@klpdv.local | klpdv123 |

## Scripts uteis

- `php artisan migrate:fresh --seed` - recria o banco com dados ficticios (pedidos, estoque e recebiveis).
- `npm run build` - gera assets otimizados em `public/build`.

---

Projeto mantido por Ray Henrique. Sugestoes e issues sao bem-vindas!
