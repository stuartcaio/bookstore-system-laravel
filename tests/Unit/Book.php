<?php
    namespace Tests\Unit;

    class Book{
        private string $title;
        private string $date;
        private string $description;

        public function __construct(string $title, string $date, string $description){
            $this->title = $title;
            $this->date = $date;
            $this->description = $description;
        }

        public function getMessage(){
            return "Título: $this->title; Data de Lançamento: $this->date; Descrição: $this->description";
        }
    }
?>