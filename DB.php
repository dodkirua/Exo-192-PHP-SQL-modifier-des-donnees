<?php

class DB {
    private string $server = "127.0.0.1";
    private string $db = "exo192";
    private string $user = "dev";
    private string $pass = "dev";

    private static ?PDO $dbInstance = null;

    /**
     * DBStatic constructor.
     */
    public function __construct(){
        try {
            self::$dbInstance = new PDO ("mysql:host=$this->server;dbname=$this->db;charset=utf8", $this->user, $this->pass);
            self::$dbInstance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     *
     */
    public static function getInstance() : ?PDO {
        if (is_null(self::$dbInstance)){
            new self();
        }
        return self::$dbInstance;
    }

    /**
     * on empeche les gens d'autres dévelloper de cloner l'objet
     * pour s'asssurer qu'on a bel et bien qu'une instance de la connexion db
     */
    public function __clone() {}

    public function requestUser($nom,$prenom,$rue,$numero,$cp,$ville,$pays,$mail){
        $request = self::$dbInstance->prepare("
        INSERT INTO exo192.user (nom,prenom,rue,numero,code_postal,ville,pays,mail)
        VALUES (:nom,:prenom,:rue,:numero,:code_postal,:ville,:pays,:mail)                        
    ");


        $request->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':rue' => $rue,
            ':numero' => $numero,
            ':code_postal' => $cp,
            ':ville' => $ville,
            ':pays' => $pays,
            ':mail' => $mail,
        ]);
    }

    public function modData($table, $column , $value, $id){
        $request = self::$dbInstance->prepare("
        UPDATE exo192.$table  SET $column = '$value' WHERE id = $id
    ");
        $request->execute();
    }


}
// UPDATE exo192.$table SET $column = $value WHERE id = $id