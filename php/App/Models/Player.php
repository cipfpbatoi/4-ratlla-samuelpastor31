<?php
namespace Joc4enRatlla\Models;


class Player {
    private $name;      // Nom del jugador
    private $color;     // Color de les fitxes
    private $isAutomatic; // Forma de jugar (automàtica/manual)

    public function __construct( $name, $color, $isAutomatic = false){
        //Inicialització de les variables
        $this->name = $name;
        $this->color = $color;
        $this->isAutomatic = $isAutomatic;
    } 

    // Getters i Setters 


    public function getName() {
    	return $this->name;
    }

    /**
    * @param $name
    */
    public function setName($name) {
    	$this->name = $name;
    }

    public function getColor() {
    	return $this->color;
    }

    /**
    * @param $color
    */
    public function setColor($color) {
    	$this->color = $color;
    }

    public function getIsAutomatic() {
    	return $this->isAutomatic;
    }

    /**
    * @param $isAutomatic
    */
    public function setIsAutomatic($isAutomatic) {
    	$this->isAutomatic = $isAutomatic;
    }
}