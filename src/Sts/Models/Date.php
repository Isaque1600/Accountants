<?php

namespace Sts\Models;

class Date
{
    private array $date;
    private array $dateFormatted;

    private function dateSetter()
    {
        $this->date = getdate();
        $this->date['mon'] = $this->date['mon'] - 1;
        if ($this->date['mon'] == 0) {
            $this->date['mon'] = 12;
            $this->date['year'] = $this->date['year'] - 1;
        }
    }

    private function dateFormatter()
    {
        switch ($this->date['mon']) {
            case '1':
                $this->dateFormatted['month'] = "Janeiro";
                break;

            case '2':
                $this->dateFormatted['month'] = "Fevereiro";
                break;

            case '3':
                $this->dateFormatted['month'] = "Março";
                break;

            case '4':
                $this->dateFormatted['month'] = "Abril";
                break;

            case '5':
                $this->dateFormatted['month'] = "Maio";
                break;

            case '6':
                $this->dateFormatted['month'] = "Junho";
                break;

            case '7':
                $this->dateFormatted['month'] = "Julho";
                break;

            case '8':
                $this->dateFormatted['month'] = "Agosto";
                break;

            case '9':
                $this->dateFormatted['month'] = "Setembro";
                break;

            case '10':
                $this->dateFormatted['month'] = "Outubro";
                break;

            case '11':
                $this->dateFormatted['month'] = "Novembro";
                break;

            case '12':
                $this->dateFormatted['month'] = "Dezembro";
                break;
        }
        $this->dateFormatted['year'] = $this->date['year'];
    }

    public function getDate()
    {
        $this->dateSetter();
        $this->dateFormatter();
        return $this->dateFormatted;
    }

}
