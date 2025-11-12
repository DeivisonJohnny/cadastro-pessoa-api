![splitphp-logo.png](https://splitphp-media-archive.s3.us-east-1.amazonaws.com/SPLIT_PHP-logo-full.png)

[![Core version](https://img.shields.io/packagist/v/splitphp/core.svg)](https://packagist.org/packages/splitphp/core)

Projeto boilerplate para criar uma nova aplicação SplitPHP.

## Instalação

### Via Composer

```bash
composer create-project splitphp/starter myapp
cd myapp
```

### Download ZIP

Baixe [aqui](https://github.com/splitphp/core/releases/latest/download/splitphp-distribution-latest.zip) e extraia:

```bash
unzip splitphp-distribution-latest.zip -d myapp
cd myapp
```

## Estrutura de Diretórios

```
myapp/
├── core/         # Framework core do SplitPHP
├── application/  # Código específico da aplicação
├── modules/      # Módulos reutilizáveis
├── public/       # Ponto de entrada web
├── config.ini    # Arquivo de configuração
├── console       # Ponto de entrada CLI
└── README.md
```

## Começando

1. Configure a aplicação:

```bash
php console setup
```

2. Inicie o servidor de desenvolvimento:

```bash
php console server:start
```

3. Acesse http://localhost:8000

## Documentação

Para documentação completa, veja o [repositório SplitPHP Core](https://github.com/splitphp/core).

## Fontes de Pesquisa

Referência principal para o desenvolvimento da API:

- [SplitPHP Documentation](https://splitphp.org/#components-service)

---

© Gabriel Valentoni Guelfi | MIT License
