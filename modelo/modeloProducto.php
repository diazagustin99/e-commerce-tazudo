<?php
class Producto {
    private $id;
    private $nombre;
    private $imagen;
    private $categoria;
    private $costo;
    private $precioMenor;
    private $precioMayor;
    private $precioOferta;
    private $oferta;
    private $estado;


    public function __construct($id, $nombre, $imagen, $categoria, $Subcategoria, $costo, $precioMenor, $precioMayor , $precioOferta, $oferta, $estado){
        $this->id=$id;
        $this->nombre=$nombre;
        $this->imagen=$imagen;
        $this->categoria=$categoria;
        $this->costo=$costo;
        $this->precioMenor=$precioMenor;
        $this->precioMayor=$precioMayor;
        $this->precioOferta=$precioOferta;
        $this->oferta=$oferta;
        $this->estado=$estado;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function getImagen(){
        return $this->imagen;
    }

    public function setImagen($imagen){
        $this->imagen=$imagen;
    }

    public function getCategoria(){
        return $this->categoria;
    }

    public function setCategoria($categoria){
        $this->categoria=$categoria;
    }

    public function getCosto(){
        return $this->costo;
    }

    public function setCosto($costo){
        $this->costo=$costo;
    }

    public function getPrecioMayor(){
        return $this->precioMayor;
    }

    public function setPrecio($precioMayor){
        $this->precioMayor=$precioMayor;
    }

    public function getPrecioMenor(){
        return $this->precioMenor;
    }

    public function setPrecioMenor($precioMenor){
        $this->precioMenor=$precioMenor;
    }

    public function getPrecioOferta(){
        return $this->precioOferta;
    }

    public function setPrecioOferta($precioOferta){
        $this->precioOferta=$precioOferta;
    }

    public function getOferta(){
        return $this->oferta;
    }

    public function setOferta($oferta){
        $this->oferta=$oferta;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function setEstado($Estado){
        $this->estado=$Estado;
    }

    
}
?>