<?php
class Graph
{
    private $colorWhite;
    private $colorGrey;
    private $colorDarkGrey;
    private $colorBlack;
    private $colorRed;
    private $colorBlue;
    private $colorPurple;
    private $colorMauve;
    private $all;
    private $date;
    private $data;
    private $width;
    private $height;
    private $image;
    private $fontFile;
    private $lastPointX;
    private $lastPointY;

    public function __construct($all, $data, $date)
    {
        //Définition des marges
        define('spaceWidth', 30);
        define('spaceHeight', 15);
        define('padding', 100);
        //Attribution des variables
        $this->all = $all;
        $this->date = $date;
        $this->data = $data;
        $this->fontFile = dirname(__FILE__) . '/arial.ttf';
        //Initialisation de l'image et des couleurs
        $this->newImage();
        $this->colors();
    }

    private function newImage()
    {
        //Définition de la hauteur et largeur
        $this->width = count($this->date)*spaceWidth+padding*2;
        $this->height = (min($this->data) < 0 ? min($this->data) + max($this->data) : max($this->data))*spaceHeight+padding*2;
        //Création de l'image
        $this->image = imagecreate($this->width, $this->height);

        //Définition du cadre
        imagerectangle($this->image, 0, 0, $this->width-1, $this->height-1, $this->colorGrey);
    }

    private function colors()
    {
        //Définition des couleurs
        $this->colorWhite = imagecolorallocate($this->image, 255, 255, 255);
        $this->colorGrey = imagecolorallocate($this->image, 192, 192, 192);
        $this->colorDarkGrey = imagecolorallocate($this->image, 112, 112, 112);
        $this->colorBlack = imagecolorallocate($this->image, 0, 0, 0);
        $this->colorRed = imagecolorallocate($this->image, 255, 0, 0);
        $this->colorBlue = imagecolorallocate($this->image, 0, 0, 255);
        $this->colorPurple = imagecolorallocate($this->image, 85, 31, 139);
        $this->colorMauve = imagecolorallocate($this->image, 139, 31, 85);
    }

    public function getNewPointGraph()
    {
        return $this->newPointGraph();
    }

    public function getGenerateImage()
    {
        return $this->generateImage();
    }

    public function getNewBarreGraph()
    {
        return $this->newBarreGraph();
    }

    private function generateImage()
    {
        imagepng($this->image);
        imagedestroy($this->image);
    }

    private function repere()
    {
        //Création du repère
        //Pour rappel, l'origine de l'image est en haut à gauche
        imageline($this->image, padding, $this->height-padding, $this->width-padding, $this->height-padding, $this->colorBlack); //Abscises
        imageline($this->image, padding, padding, padding, $this->height-padding, $this->colorBlack); //Ordonnés
        //Création des lignes repères
        for ($i = 1; $i <= max($this->data); $i++) {
            //Création des lignes abscises
            imageline($this->image, padding+1, $this->height-$i*spaceHeight-padding, $this->width-padding-1, $this->height-$i*spaceHeight-padding, $this->colorGrey);
            //Création du texte
            imagefttext($this->image, 10, 0, padding-17, $this->height-$i*spaceHeight-padding+5, $this->colorBlack, $this->fontFile, $i);
        }
    }

    private function newPointGraph()
    {
        $this->repere();
        //Placement des points
        foreach ($this->data as $key => $valeur) {
            $pointX = padding+$key*spaceWidth+spaceWidth;
            $pointY = $this->height-$valeur*spaceHeight-padding;
            imagefilledellipse($this->image, $pointX, $pointY, 6, 6, $this->colorRed); //On mets un point
            imageline($this->image, $pointX, $this->height-padding-1, $pointX, $pointY, $this->colorDarkGrey);
            imagefttext($this->image, 8, 80, $pointX-8, $this->height-10, $this->colorBlack, $this->fontFile, $this->all[$key][3]); //On mets la date
            if ($key !== 0) {
                imageline($this->image, $pointX-2.5, $pointY, $this->lastPointX+2.5, $this->lastPointY, $this->colorBlue);
                $this->lastPointX = $pointX;
                $this->lastPointY = $pointY;
            } else {
                $this->lastPointX = padding+$key*spaceWidth+spaceWidth;
                $this->lastPointY = $this->height-$valeur*spaceHeight-padding;
            }
        }
    }

    private function newBarreGraph()
    {
        $this->repere();
        //Création des barres
        $i = 0;
        foreach ($this->data as $key => $valeur) {
            $pointX = padding+$key*spaceWidth+1;
            $pointY = $this->height-$valeur*spaceHeight-padding;
            if ($i == 0) {
                imagefilledrectangle($this->image, $pointX, $this->height-padding-1, $pointX+spaceWidth, $pointY, $this->colorPurple); //On mets un point
                $i++;
            } elseif ($i == 1) {
                imagefilledrectangle($this->image, $pointX, $this->height-padding-1, $pointX+spaceWidth, $pointY, $this->colorMauve); //On mets un point
                $i--;
            }
            imagefttext($this->image, 8, 80, $pointX-8, $this->height-10, $this->colorBlack, $this->fontFile, $this->all[$key][3]); //On mets la date
        }
    }
}