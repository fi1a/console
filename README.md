# Консольные команды на PHP. Аргументы, опции и форматирование

[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
![Coverage Status][badge-coverage]
[![Total Downloads][badge-downloads]][downloads]

Это библиотека PHP для реализации команд и красивого форматирования текста в консоли.

Возможности:

- Команды получают автоматическую поддержку --help для вывода справки;
- Поддержка одной или нескольких команд;
- Возможность валидации (проверки) значений передаваемых в качестве аргументов и опций в команду;
- Цветовое оформление в консоли;
- Компоненты реализующие таблицы, списки, деревья и т.д.

## Установка

Установить этот пакет можно как зависимость, используя Composer.

``` bash
composer require fi1a/console ~1.0
```

## Использование

### Команды, аргументы и опции в консоли

Класс ```Fi1a\Console\App``` предоставляет удобный интерфейс для добавления команд и запуска приложения.

#### Команды

Команда должна реализовывать интерфейс ```Fi1a\Console\CommandInterface```.
Вот пример простой команды.

```php

declare(strict_types=1);

namespace Foo\Bar;

/**
 * Простая команда
 */
class BazCommand extends AbstractCommand
{
    /**
     * @inheritDoc
     */
    public function __construct(DefinitionInterface $definition)
    {
        $definition->addOption('time', 't')
            ->default(false)
            ->description('Вывод времени.')
            ->validation()
            ->allOf()
            ->boolean();

        $definition->addArgument('format')
            ->default('H:i:s')
            ->description('Формат вывода времени.');
    }

    /**
     * @inheritDoc
     */
    public function run(
        InputArgumentsInterface $input,
        ConsoleOutputInterface $output,
        InputInterface $stream,
        DefinitionInterface $definition,
        AppInterface $app
    ): int {
        $output->writeln('<option=bold>Пример команды</>');
        
        if ($definition->getOption('time')->getValue()) {
            $output->writeln(
                '<success>Серверное время: <option=bold>{{time}}</></success>',
                ['time' => date($definition->getArgument('format')->getValue())]
            );
        }
        
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Тестовая команда baz.';
    }
}
```

В этом примере добавляется опция ```time``` и аргумент ```format``` в конструкторе команды.
После запуска команды проверяется передана ли опция ```time``` и если передана выводит серверное время
с указанным форматом ```format```. Если формат не передан, метод ```getValue```
вернет значение указанное по умолчанию с помощью метода ```default```.

![Запуск команды](images/console-command-run.png)

В метод ```run``` вызываемый при запуске команды в качестве аргументов передается:
- ```InputArgumentsInterface $input``` - входящие аргументы и опции;
- ```ConsoleOutputInterface $output``` - вывод в консоль;
- ```InputInterface $stream``` -  потоковый ввод из консоли;
- ```DefinitionInterface $definition``` - доступ к объявленным аргументам и опциям;
- ```AppInterface $app``` - объект класса ```Fi1a\Console\App``` вызвавший данную команду.

#### Использование опций и аргументов

В метод ```run``` передается объект класса ```DefinitionInterface $definition```, который можно
использовать для доступа к значениям опций и аргументов.

```php
$definition->getOption('time')->getValue();
$definition->getArgument('format')->getValue();
```

- Опции передаются с помощью --name=value полного имени или -s value короткого кода;
- Аргументы передаются как просто строки, разделенные пробелами.

#### Запуск консольного приложения

Чтобы использовать приложение, нужно вызвать метод ```run```.
Метод ```run``` делает следующее:

- Анализирует параметр $argv для определения команды;
- Валидирует опции и аргументы;
- Осуществляет конфигурацию команды;
- Запускает команду на выполнение.

Запуск одной конкретной команды.
Данный код запустит команду ```\Foo\Bar\BazCommand``` на выполнение:

```php

declare(strict_types=1);

use Fi1a\Console\App;

$code = (new App())
    ->run(\Foo\Bar\BazCommand::class);

exit($code);
```

Запуск нескольких команд указанных в первом аргументе.
Если передать в качестве первого аргумента название команды ```php foo.php qux```
будет запущена команда ```\Foo\Bar\QuxCommand```.

```php

declare(strict_types=1);

use Fi1a\Console\App;

$code = (new App())
    ->addCommand('baz', \Foo\Bar\BazCommand::class)
    ->addCommand('qux', \Foo\Bar\QuxCommand::class)
    ->run();

exit($code);
```

#### Список команд

Вызов скрипта, который имеет несколько команд без параметров или только с аргументом info,
отобразит список доступных команд. Пример:

```php foo.php``` или ```php foo.php info```

![Список команд](images/console-info.png)

Описание команды берется из значения возвращаемого методом ```description```.

#### Отображение справки

Если вызвать команду с параметром --help (```php foo.php baz --help```), можно увидеть следующую справку по команде:

![Отображение справки](images/console-help.png)

Описание команды берется из значения возвращаемого методом ```description```.

#### Отображение ошибок

Допустим, вы вызываете пример ```php foo.php baz -t j```. Вы увидите следующее сообщение об ошибке:

![Сообщения об ошибках](images/console-errors.png)

Валидация осуществляется с помощью пакета [fi1a/validation](https://github.com/fi1a/validation).
Доступны все правила валидации.

```php
$definition->addOption('option1')
    ->validation()
    ->allOf()
    ->required()
    ->min(10)
    ->max(20);

$argument = $definition->addArgument('argument1')
    ->multiple();

$argument->multipleValidation()
    ->allOf()
    ->array()
    ->required()
    ->minCount(2);

$argument->validation()
    ->allOf()
    ->required()
    ->min(10)
    ->max(20);
```

- метод ```validation``` - правила валидации одного значения;
- метод ```multipleValidation``` - правила валидации множества значений.

### Оформление

#### Цветовые схемы (палитра цветов консоли):

Доступны три цветовые схемы:

- ANSI (4-bit color);
- Extended (8-bit color);
- TrueColor (16.7 million).

Запустить пример с отображением палитры цветов

```shell
php examples/examples.php colors
```

![Пример с отображением палитры цветов](images/console-colors.png)

#### Вывод в консоль

Используя цвета в выводе консоли, вы можете оформить разные типы вывода (ошибки, заголовки, комментарии и т. д.).

##### Использование цветовых стилей

При выводе вы можете использовать теги чтобы раскрасить его.

```php

...

/**
 * @inheritDoc
 */
public function run(
    InputArgumentsInterface $input,
    ConsoleOutputInterface $output,
    InputInterface $stream,
    DefinitionInterface $definition,
    AppInterface $app
): int {
    $output->writeln('<info>foo</info>');
    $output->writeln('<error>bar</error>');
    $output->writeln('<success>baz<info>qux</info></success>');
}

...

```

Можно определить свои собственные стили, используя метод ```addStyle``` класса ```Fi1a\Console\IO\Formatter```:

```php
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Style\TrueColor;
use Fi1a\Console\IO\Style\TrueColorStyle;

Formatter::addStyle('error', new TrueColorStyle(TrueColor::WHITE, TrueColor::RED));
```

Любой шестнадцатеричный цвет поддерживается для цветов TrueColor.
Кроме того, поддерживаются названные цвета опредяемых константами интерфейса
```Fi1a\Console\IO\Style\ColorInterface``` (```ColorInterface::BLACK```, ```ColorInterface::RED```, ```ColorInterface::GREEN``` ...).

Если терминал не поддерживает TrueColor или Extended, используется ближайший ANSI цвет.

Доступны параметры оформления: blink, bold, conceal, reverse, underscore.
Вы можете установить цвет, фон и параметры непосредственно внутри тега:

```php

...

/**
 * @inheritDoc
 */
public function run(
    InputArgumentsInterface $input,
    ConsoleOutputInterface $output,
    InputInterface $stream,
    DefinitionInterface $definition,
    AppInterface $app
): int {
    $output->writeln('<color=black>foo</>');
    $output->writeln('<bg=white;color=black>bar</>');
    $output->writeln('<color=red>baz<option=bold,underscore>qux</></>');
}

...

```

Поддерживается вложенность стилей.

Запустить пример с отображением форматированного вывода

```shell
php examples/examples.php output
```

![Пример форматированного вывода в консоль](images/console-output.png)

#### Потоковый ввод из консоли

Чтение (ввод) из консоли осуществляется методом ```read``` объекта класса ```InputInterface $stream```.

```php

...

/**
 * @inheritDoc
 */
public function run(
    InputArgumentsInterface $input,
    ConsoleOutputInterface $output,
    InputInterface $stream,
    DefinitionInterface $definition,
    AppInterface $app
): int {
    $value = $stream->read('y');
}

...

```

#### Интерактивный ввод из консоли

С помощью класса ```Fi1a\Console\IO\InteractiveInput``` можно добавить значения для чтения
из консоли и получить последующий доступ к введенным значениям. 
С помощью метода ```addValue``` добавляем значение для чтения из консоли. Также как для аргументов
и опций доступны валидаторы значений из пакета [fi1a/validation](https://github.com/fi1a/validation)

```php

use Fi1a\Console\IO\InteractiveInput;

...

/**
 * @inheritDoc
 * @psalm-suppress PossiblyFalseReference
 * @psalm-suppress MixedMethodCall
 */
public function run(
    InputArgumentsInterface $input,
    ConsoleOutputInterface $output,
    InputInterface $stream,
    DefinitionInterface $definition,
    AppInterface $app
): int {
    $output->writeln(['', '<option=bold>Интерактивный ввод</>', '']);

    $interactive = new InteractiveInput($output, $stream);

    $interactive->addValue('foo')
        ->description('Введите количество от 1 до 10')
        ->validation()
        ->allOf()
        ->min(1)
        ->max(10);

    $bar = $interactive->addValue('bar')
        ->description('Введите строки длиной от 2-х символов')
        ->multiple();

    $bar->multipleValidation()
        ->allOf()
        ->minCount(1)
        ->required();

    $bar->validation()
        ->allOf()
        ->minLength(2);

    $interactive->addValue('baz')
        ->description('Согласны (y/n)')
        ->validation()
        ->allOf()
        ->boolean();

    $interactive->read();

    // Доступ к введенным значениям
    $output->writeln((string) $interactive->getValue('foo')->getValue());
    $output->writeln((string) count((array) $interactive->getValue('bar')->getValue()));
    $output->writeln((string) $interactive->getValue('baz')->getValue());

    return 0;
}

...

```

Запустить пример с интерактивным вводом

```shell
php examples/examples.php interactive
```

![Интерактивный ввод](images/console-interactive.png)

### Компоненты

#### Компонент панели

Чтобы нарисовать границу  вокруг текста или задать выравнивание, используйте ```Fi1a\Console\Component\PanelComponent\PanelComponent```.
Компонент панели может быть вложен друг в друга.

```php

use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\PanelComponent\PanelStyleInterface;
use Fi1a\Console\IO\Style\ColorInterface;

...

/**
 * @inheritDoc
 */
public function run(
    InputArgumentsInterface $input,
    ConsoleOutputInterface $output,
    InputInterface $stream,
    DefinitionInterface $definition,
    AppInterface $app
): int {
    $panelStyle = new PanelStyle();

    $panelStyle->setWidth(40)
        ->setPadding(1)
        ->setBorder('heavy')
        ->setBackgroundColor(ColorInterface::YELLOW)
        ->setBorderColor(ColorInterface::RED)
        ->setColor(ColorInterface::BLACK)
        ->setAlign(PanelStyleInterface::ALIGN_CENTER);

    $panel = new PanelComponent(
        $output,
        'Lorem ipsum dolor sit amet, <error>consectetur adipiscing elit</error>, '
        . 'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        $panelStyle
    );

    $panel->display();

    return 0;
}

...

```

Запустить пример с отображением панелей

```shell
php examples/examples.php panel
```

![Панели](images/console-panel.png)

Вы можете изменить стиль границы панели, задав одно из следующих значений:

- ascii;
- double;
- heavy;
- horizontals;
- rounded.

Запустить пример со стилями границ панели

```shell
php examples/examples.php panel-borders
```

![Стили границ панели](images/console-panel-borders.png)

#### Компонент группы

Чтобы панели были одной высоты и распологались на одной линии можно использовать компонент группы.

```php

use Fi1a\Console\Component\GroupComponent\GroupComponent;
use Fi1a\Console\Component\GroupComponent\GroupStyle;
use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;

...

/**
 * @inheritDoc
 */
public function run(
    InputArgumentsInterface $input,
    ConsoleOutputInterface $output,
    InputInterface $stream,
    DefinitionInterface $definition,
    AppInterface $app
): int {
    $groupStyle = new GroupStyle(40);
    $groupStyle->setPanelSpacing(2);
    $group = new GroupComponent($output, $groupStyle);

    $panelStyle = new PanelStyle();
    $panelStyle->setBorder('heavy')
        ->setPadding(1);

    $panel1 = new PanelComponent(
        $output,
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit, '
        . 'sed do eiusmod tempor incididunt ut '
        . 'labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris '
        . 'nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit '
        . 'in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat '
        . 'non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        $panelStyle
    );
    $panel2 = new PanelComponent(
        $output,
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit, '
        . 'sed do eiusmod tempor incididunt ut '
        . 'labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris '
        . 'nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit '
        . 'in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        $panelStyle
    );
    $panel3 = new PanelComponent(
        $output,
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit, '
        . 'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        $panelStyle
    );

    $group->addPanel($panel1);
    $group->addPanel($panel2);
    $group->addPanel($panel3);

    $group->display();
        
    return 0;
}

...

```

Запустить пример с группой панелей

```shell
php examples/examples.php group
```

![Группа панелей](images/console-group.png)


[badge-release]: https://img.shields.io/packagist/v/fi1a/console?label=release
[badge-license]: https://img.shields.io/github/license/fi1a/console?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/fi1a/console?style=flat-square
[badge-coverage]: https://img.shields.io/badge/coverage-100%25-green
[badge-downloads]: https://img.shields.io/packagist/dt/fi1a/console.svg?style=flat-square&colorB=mediumvioletred

[packagist]: https://packagist.org/packages/fi1a/console
[license]: https://github.com/fi1a/console/blob/master/LICENSE
[php]: https://php.net
[downloads]: https://packagist.org/packages/fi1a/console