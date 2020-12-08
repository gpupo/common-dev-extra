Extra Tools for PHP package development

[![Build Status](https://secure.travis-ci.org/gpupo/common-dev-extra.png?branch=master)](http://travis-ci.org/gpupo/common-dev-extra)


## Requisitos para uso

* PHP *>=8.0*
* [Composer Dependency Manager](http://getcomposer.org)

Este componente **não é uma aplicação Stand Alone** e seu objetivo é ser utilizado como biblioteca.
Sua implantação deve ser feita por desenvolvedores experientes.

**Isto não é um Plugin!**

As opções que funcionam no modo de comando apenas servem para depuração em modo de
desenvolvimento.

A documentação mais importante está nos testes unitários. Se você não consegue ler os testes unitários, eu recomendo que não utilize esta biblioteca.


## Direitos autorais e de licença

Este componente está sob a [licença MIT](https://github.com/gpupo/common-sdk/blob/master/LICENSE)

Para a informação dos direitos autorais e de licença você deve ler o arquivo
de [licença](https://github.com/gpupo/common-sdk/blob/master/LICENSE) que é distribuído com este código-fonte.

### Resumo da licença

Exigido:

- Aviso de licença e direitos autorais

Permitido:

- Uso comercial
- Modificação
- Distribuição
- Sublicenciamento

Proibido:

- Responsabilidade Assegurada

## Instalação

Adicione o pacote ao seu projeto utilizando [composer](http://getcomposer.org):

    composer require --dev gpupo/common-dev-extra


## Uso

### CS Configurator

1) Crie o arquivo de configuração do ``vendor/bin/php-cs-fixer fix`` (``.php_cs.dist``) conforme o exemplo:

```php
<?php
//.php_cs.dist
require __DIR__.'/vendor/autoload.php';

use Gpupo\CommonDevExtra\CsConfigurator;

$packageInfo = [
	'project' => 'foo/bar',
	'author' => 'Outer Bass <my@basses.com>',
	'url' => 'https://basses.com/',
];

return (new CsConfigurator(__DIR__))->getConfig($packageInfo);

```

2) Execute o vendor/bin/php-cs-fixer fix


	vendor/bin/php-cs-fixer fix


### Uso global

You can use with composer global and not require any autoload at ``.php_cs.dist`` file

	composer global require gpupo/common-dev-extra:dev-master --no-cache
