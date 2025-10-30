<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $schools = [
        //Vidusskolas
    ['name' => 'Austrumlatvijas Tehnoloģiju vidusskola', 'region' => 'Latgale', 'type' => 'Vidusskola'],
    ['name' => 'Babītes vidusskola', 'region' => 'Pierīga', 'type' => 'Vidusskola'],
    ['name' => 'Daugavpils Draudzīgā aicinājuma vidusskola', 'region' => 'Latgale', 'type' => 'Vidusskola'],
    ['name' => 'Daugavpils Iespēju vidusskola', 'region' => 'Latgale', 'type' => 'Vidusskola'],
    ['name' => 'Daugavpils Tehnoloģiju vidusskola - licejs', 'region' => 'Latgale', 'type' => 'Vidusskola'],
    ['name' => 'Daugavpils Valstspilsētas vidusskola', 'region' => 'Latgale', 'type' => 'Vidusskola'],
    ['name' => 'Daugavpils Zinātņu vidusskola', 'region' => 'Latgale', 'type' => 'Vidusskola'],
    ['name' => 'Druvas vidusskola', 'region' => 'Kurzeme', 'type' => 'Vidusskola'],
    ['name' => 'Iecavas vidusskola', 'region' => 'Zemgale', 'type' => 'Vidusskola'],
    ['name' => 'Ikšķiles vidusskola', 'region' => 'Pierīga', 'type' => 'Vidusskola'],
    ['name' => 'J.G.Herdera Rīgas Grīziņkalna vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Jelgavas 4. vidusskola', 'region' => 'Zemgale', 'type' => 'Vidusskola'],
    ['name' => 'Jelgavas Tehnoloģiju vidusskola', 'region' => 'Zemgale', 'type' => 'Vidusskola'],
    ['name' => 'Jūrmalas Pumpuru vidusskola', 'region' => 'Pierīga', 'type' => 'Vidusskola'],
    ['name' => 'Jēkabpils 3. vidusskola', 'region' => 'Zemgale', 'type' => 'Vidusskola'],
    ['name' => 'Ķekavas vidusskola', 'region' => 'Pierīga', 'type' => 'Vidusskola'],
    ['name' => 'Kuldīgas Centra vidusskola', 'region' => 'Kurzeme', 'type' => 'Vidusskola'],
    ['name' => 'Liepājas Draudzīgā aicinājuma vidusskola', 'region' => 'Kurzeme', 'type' => 'Vidusskola'],
    ['name' => 'Liepājas Liedaga vidusskola', 'region' => 'Kurzeme', 'type' => 'Vidusskola'],
    ['name' => 'Liepājas Raiņa vidusskola', 'region' => 'Kurzeme', 'type' => 'Vidusskola'],
    ['name' => 'Olaines 1. vidusskola', 'region' => 'Pierīga', 'type' => 'Vidusskola'],
    ['name' => 'Ozolnieku vidusskola', 'region' => 'Zemgale', 'type' => 'Vidusskola'],
    ['name' => 'Rēzeknes 2. vidusskola', 'region' => 'Latgale', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas 1. vidusskola (tālmācība)', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas 34. vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas 40. vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas 49. vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas 64. vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas 72. vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas 84. vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas 95. vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Angļu ģimnāzija', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Centra humanitārā vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Dārzciema vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Franču licejs', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Hanzas vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Imantas vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Jāņa Šteinhauera vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Juglas vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Komercskola (tālmācība)', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Natālijas Draudziņas vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Purvciema vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Teikas vidusskola', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Rīgas Zolitūdes ģimnāzija', 'region' => 'Rīga', 'type' => 'Vidusskola'],
    ['name' => 'Salaspils 1. vidusskola', 'region' => 'Pierīga', 'type' => 'Vidusskola'],
    ['name' => 'Saldus vidusskola', 'region' => 'Kurzeme', 'type' => 'Vidusskola'],
    ['name' => 'Smiltenes vidusskola', 'region' => 'Vidzeme', 'type' => 'Vidusskola'],
    ['name' => 'Tukuma 2. vidusskola', 'region' => 'Zemgale', 'type' => 'Vidusskola'],
    ['name' => 'V. Plūdoņa Kuldīgas vidusskola', 'region' => 'Kurzeme', 'type' => 'Vidusskola'],
    ['name' => 'Valmieras Viestura vidusskola', 'region' => 'Vidzeme', 'type' => 'Vidusskola'],
    ['name' => 'Ventspils 2. vidusskola', 'region' => 'Kurzeme', 'type' => 'Vidusskola'],
    ['name' => 'Ventspils 4. vidusskola', 'region' => 'Kurzeme', 'type' => 'Vidusskola'],
    ['name' => 'Ventspils 6. vidusskola', 'region' => 'Kurzeme', 'type' => 'Vidusskola'],
    ['name' => 'Zemgales vidusskola', 'region' => 'Zemgale', 'type' => 'Vidusskola'],
    //Augstskolas
    ['name' => 'Biznesa augstskola Turība', 'region' => 'Rīga', 'type' => 'Privāta augstskola'],
    ['name' => 'Daugavpils Universitāte', 'region' => 'Latgale', 'type' => 'Valsts universitāte'],
    ['name' => 'Jāzepa Vītola Latvijas Mūzikas akadēmija', 'region' => 'Rīga', 'type' => 'Valsts augstskola'],
    ['name' => 'Latvijas Jūras akadēmija', 'region' => 'Rīga', 'type' => 'Valsts augstskola'],
    ['name' => 'Latvijas Kultūras akadēmija', 'region' => 'Rīga', 'type' => 'Valsts augstskola'],
    ['name' => 'Latvijas Lauksaimniecības universitāte', 'region' => 'Zemgale', 'type' => 'Valsts universitāte'],
    ['name' => 'Latvijas Mākslas akadēmija', 'region' => 'Rīga', 'type' => 'Valsts augstskola'],
    ['name' => 'Latvijas Nacionālā aizsardzības akadēmija', 'region' => 'Rīga', 'type' => 'Valsts augstskola'],
    ['name' => 'Latvijas Sporta pedagoģijas akadēmija', 'region' => 'Rīga', 'type' => 'Valsts augstskola'],
    ['name' => 'Latvijas Universitāte', 'region' => 'Rīga', 'type' => 'Valsts universitāte'],
    ['name' => 'Liepājas Universitāte', 'region' => 'Kurzeme', 'type' => 'Valsts universitāte'],
    ['name' => 'Rēzeknes Tehnoloģiju akadēmija', 'region' => 'Latgale', 'type' => 'Valsts augstskola'],
    ['name' => 'Rīgas Stradiņa universitāte', 'region' => 'Rīga', 'type' => 'Valsts universitāte'],
    ['name' => 'Rīgas Tehniskā universitāte', 'region' => 'Rīga', 'type' => 'Valsts universitāte'],
    ['name' => 'Ventspils Augstskola', 'region' => 'Kurzeme', 'type' => 'Valsts augstskola'],
    ['name' => 'Vidzemes Augstskola', 'region' => 'Vidzeme', 'type' => 'Valsts augstskola'],
    //Tehnikumi
    ['name' => 'Daugavpils Tehnoloģiju un tūrisma tehnikums', 'region' => 'Latgale', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Jelgavas tehnikums', 'region' => 'Zemgale', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Kandavas Lauksaimniecības tehnikums', 'region' => 'Kurzeme', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Kuldīgas Tehnoloģiju un tūrisma tehnikums', 'region' => 'Kurzeme', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Latgales Industriālais tehnikums', 'region' => 'Latgale', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Liepājas Valsts tehnikums', 'region' => 'Kurzeme', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Ogres tehnikums', 'region' => 'Vidzeme', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Rēzeknes tehnikums', 'region' => 'Latgale', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Rīgas Mākslas un mediju tehnikums', 'region' => 'Rīga', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Rīgas Tūrisma un radošās industrijas tehnikums', 'region' => 'Rīga', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Rīgas Stila un modes tehnikums', 'region' => 'Rīga', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Rīgas Valsts tehnikums', 'region' => 'Rīga', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Saldus tehnikums', 'region' => 'Kurzeme', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Smiltenes tehnikums', 'region' => 'Vidzeme', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Valmieras tehnikums', 'region' => 'Vidzeme', 'type' => 'Profesionālā izglītības iestāde'],
    ['name' => 'Ventspils Tehnikums', 'region' => 'Kurzeme', 'type' => 'Profesionālā izglītības iestāde'],
];

    }
}