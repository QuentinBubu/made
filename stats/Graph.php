<?php
class Graph
{
    //Définition des variables
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
        define('paddingLeft', 25);
        define('paddingBottom', 100);

        //Attribution de certaines variables
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
        $this->width = count($this->date)*spaceWidth+paddingLeft;
        $this->height = max($this->data)*spaceHeight+paddingBottom+spaceHeight;
        //Création de l'image
        $this->image = imagecreate($this->width+8, $this->height);

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
        imageline($this->image, paddingLeft, $this->height-paddingBottom, $this->width, $this->height-paddingBottom, $this->colorBlack); //Abscises
        imageline($this->image, paddingLeft, $this->height-paddingBottom, paddingLeft, spaceHeight, $this->colorBlack); //Ordonnés
        //Création des lignes repères
        for ($i = 1; $i <= max($this->data); $i++) {
            //Création des lignes abscises
            imageline($this->image, paddingLeft+1, $this->height-$i*spaceHeight-paddingBottom, $this->width-1, $this->height-$i*spaceHeight-paddingBottom, $this->colorGrey);
            //Création du texte
            imagefttext($this->image, 8, 0, paddingLeft-17, $this->height-$i*spaceHeight-paddingBottom+5, $this->colorBlack, $this->fontFile, $i);
        }
    }

    private function newPointGraph()
    {
        $this->repere();
        //Placement des points
        foreach ($this->data as $key => $valeur) {

            $pointX = paddingLeft+$key*spaceWidth+spaceWidth;
            $pointY = $this->height-$valeur*spaceHeight-paddingBottom;

            imagefilledellipse($this->image, $pointX, $pointY, 6, 6, $this->colorRed); //On mets un point
            imageline($this->image, $pointX, $this->height-paddingBottom-1, $pointX, $pointY, $this->colorDarkGrey);
            imagefttext($this->image, 8, 80, $pointX-8, $this->height-10, $this->colorBlack, $this->fontFile, $this->all[$key][3]); //On mets la date

            if ($key !== 0) {
                imageline($this->image, $pointX-2.5, $pointY, $this->lastPointX+2.5, $this->lastPointY, $this->colorBlue);
                $this->lastPointX = $pointX;
                $this->lastPointY = $pointY;
            } else {
                $this->lastPointX = paddingLeft+$key*spaceWidth+spaceWidth;
                $this->lastPointY = $this->height-$valeur*spaceHeight-paddingBottom;
            }
        }
    }

    private function newBarreGraph()
    {
        //Création du repère
        $this->repere();
        //Création des barres
        $i = 0;
        foreach ($this->data as $key => $valeur) {
            $pointX = paddingLeft+$key*spaceWidth+1;
            $pointY = $this->height-$valeur*spaceHeight-paddingBottom;
            if ($i == 0) {
                imagefilledrectangle($this->image, $pointX, $this->height-paddingBottom-1, $pointX+spaceWidth, $pointY, $this->colorPurple); //On mets le rectangle
                $i++;
            } elseif ($i == 1) {
                imagefilledrectangle($this->image, $pointX, $this->height-paddingBottom-1, $pointX+spaceWidth, $pointY, $this->colorMauve); //On mets le rectangle
                $i--;
            }
            imagefttext($this->image, 8, 80, $pointX-8, $this->height-10, $this->colorBlack, $this->fontFile, $this->all[$key][3]); //On mets le rectangle
        }
    }
}

/*
 Code écrit pas https://github.com/QuentinBubu/
 Pour https://made.alwaysdata.net
 Voir vos droits https://github.com/QuentinBubu/made/tree/master/stats
*/