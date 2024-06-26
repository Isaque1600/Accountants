<?php

namespace Sts\Models\Helpers;

class Select
{

    private object $connect;

    public function __construct()
    {
        $this->setConnect();
    }

    public function selectAllByName(string $name)
    {

        try {

            $query = $this->connect->prepare("SELECT RAZAO FROM PESSOAS WHERE CONTADOR = :name AND SITUACAO = 'SIM' AND SPED = 'SIM' ORDER BY RAZAO");

            $query->bindParam(":name", $name, \PDO::PARAM_STR);

            if ($query->execute()) {
                return $query->fetchAll(\PDO::FETCH_ASSOC);
            }

        } catch (\PDOException $err) {
            throw $err;
        }
    }

    private function setConnect(): void
    {
        $connect = new Con();
        $this->connect = $connect->connect();
    }

}
