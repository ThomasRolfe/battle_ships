<h1>Battle Ships</h1>

<h3>Setup</h3>
<p>Requires composer.</p>
<p>Run:</p>

``` 
composer install
``` 

<p>The project does not use any components/libraries that dont already come bundled with Laravel.</p>

<h3>Usage</h3>
<p>The combat system can be played through tinker in the project root directory:</p>

```
php artisan tinker
```

Create two ships, one offensive and one defensive style

```
$shipA = factory(App\Models\Ship::class)->states('offensive')->make()
$shipB = factory(App\Models\Ship::class)->states('defensive')->make()
```

<p>The ships can now be used by the combat service to attack each other. Each attack will return the impact type and damage done.</p>
<p>The first ship provided as an argument will be the attacking ship, the second argument will be the defending ship.</p>

```
App\Services\Combat\CombatService::attack($shipA, $shipB)


 // [
 //    "impact" => [
 //      "name" => "hit",
 //      "chance" => 65,
 //      "multiplier" => 1,
 //    ],
 //    "resulting_damage" => 2,
 // ]

```

<p>This process can be repeated, alternating which ship is attacking.</p>

<p>The current health of a ship can be checked by calling its reference:</p>

```
$shipA

// App\Models\Ship {#3078
//    health: 0,
//    attack: 15,
//    defence: 5,
// }


```

<p>Once a ship reaches 0 health it will no longer be able to attack or be attacked.</p>

<h3>Testing</h3>
<p>Run PHPUnit tests from the root of the project directory with:</p>

```
vendor/bin/phpunit
```
