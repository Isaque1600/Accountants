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

            $query = $this->connect->prepare("SELECT RAZAO FROM PESSOAS WHERE CONTADOR = :name AND (SITUACAO = 'SIM' OR SITUACAO = 'ativo' OR SITUACAO = 'sim') AND SPED = 'SIM' ORDER BY RAZAO");

            $query->bindParam(":name", $name, \PDO::PARAM_STR);

            if ($query->execute()) {
                if ($query->rowCount() >= 1) {
                    return $query->fetchAll(\PDO::FETCH_ASSOC);
                }
                return null;
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
