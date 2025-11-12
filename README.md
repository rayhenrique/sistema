# KL PDV · Sistema de Gestão Comercial

Aplicação Laravel 12 com Tailwind 4 pensada para pequenas e médias empresas controlarem vendas, pedidos e estoque em um único painel.

## Principais recursos
- **Geração de pedidos** com itens, descontos e impressão (A4 ou cupom não fiscal).
- **Catálogo de clientes, produtos e fornecedores** com histórico e termos de pagamento.
- **Controle de estoque em tempo real** (entradas, saídas e alertas de estoque mínimo).
- **Status de remessa e contas a receber**, incluindo parcelamentos com PIX, boleto, promissória, cartão e outros meios.
- **Dashboard resumido** com métricas financeiras, últimos pedidos, clientes top e alertas de reposição.
- **Gestão de usuários** com perfis (administrador, gerente, vendedor) pronta para integrar com autenticação Laravel.

## Stack

| Camada        | Tecnologia                              |
| ------------- | --------------------------------------- |
| Backend       | PHP 8.3 + Laravel v12.38                |
| Frontend      | Vite + Tailwind CSS 4                   |
| Banco de dados| MySQL 8 (via XAMPP)                     |

## Configuração rápida

```bash
cp .env.example .env          # ajuste DB e APP_TIMEZONE
composer install
npm install
php artisan key:generate
php artisan migrate --seed    # cria dados de demonstração
npm run dev                   # ou npm run build para produção
php artisan serve             # ou configure no Apache do XAMPP
```

Usuários de teste criados pelo seeder:

| Perfil        | Login                 | Senha     |
| ------------- | --------------------- | --------- |
| Administrador | admin@klpdv.local     | klpdv123  |
| Gerente       | gerente@klpdv.local   | klpdv123  |

## Scripts úteis

- `php artisan migrate:fresh --seed` — recria o banco com pedidos, estoque e contas a receber fictícias.
- `npm run build` — gera os assets para o diretório `public/build`.

---

Projeto mantido por Ray Henrique · sugestões e issues são bem-vindas!
