<?php
require_once __DIR__.'/class-ext-base-template.php';

class Ext_Base_Pagination {
    public $pag;
    public $total;
    public $totalPag;
    public $regPorPag;
    public $link;
    public $classAtual = 'class="active"';
    public $semLink = 'javascript:void(0)';
    public $classDisable = 'class="disabled"';
    public $limit;
    public $offset;
    public $maxPaginas = 5;

    public function __construct($total, $regPorPag = null) {
        $this->regPorPag = $regPorPag ? $regPorPag : 20;
        $this->pag = empty($_REQUEST['pag']) ? 1 : intval($_REQUEST['pag']);
        $this->calcLimit($total);
    }

    public function calcLimit($total) {
        $this->total    = $total;
        $this->totalPag = ceil($this->total/$this->regPorPag);

        if('last' == $this->pag) {
            $this->pag = $this->totalPag;
        }
        if('first' == $this->pag) {
            $this->pag = 1;
        }

        $this->limit  = $this->regPorPag;
        $this->offset = ($this->pag - 1) * $this->regPorPag;
    }

    public function getHtml() {
        $this->totalPag = ceil($this->total / $this->regPorPag);

        if ($this->totalPag > 1) {
            $tpl = new Ext_Base_Template(EXT_BASE_DIR.'/views/pagination.tpl');
            $l_max = ceil($this->maxPaginas / 2) - 1;
            $r_max = $this->maxPaginas - $l_max - 1;

            $this->link .= '?pag=';

            $tpl->link_anterior = $this->pag > 1 ? $this->link.($this->pag - 1) : $this->semLink;
            $tpl->class_prev = $this->pag > 1 ? '' : $this->classDisable;
            $tpl->link_proxima = $this->pag < $this->totalPag ? $this->link.($this->pag + 1) : $this->semLink;
            $tpl->class_next = $this->pag > 1 ? '' : $this->classDisable;

            if ($this->pag > ($l_max + 1) && $this->totalPag - $this->pag >= $r_max) {
                for ($i = $l_max - 1; $i >= 0; $i--) {
                    $tpl->pag = $this->pag - $i - 1;
                    $tpl->link_pag = $this->link.$tpl->pag;
                    $tpl->pag_atual = '';
                    $tpl->block('PAGITEM');
                }

                $tpl->pag = $this->pag;
                $tpl->link_pag = $this->semLink;
                $tpl->pag_atual = $this->classAtual;
                $tpl->block('PAGITEM');

                for ($i = 1; $i < ($r_max + 1); $i++) {
                    $tpl->pag = $this->pag + $i;
                    $tpl->pag_atual = '';
                    $tpl->link_pag = $this->link.$tpl->pag;
                    $tpl->block('PAGITEM');
                }

            } else {
                $max_pag = $r_max+$l_max+1;

                if (($this->totalPag-$this->pag < $r_max) and ($this->totalPag > $max_pag)) {
                    $inicio = $this->totalPag-$max_pag+1;
                    $fim = $this->totalPag;
                } else {
                    $inicio = 1;
                    $fim = min($max_pag, $this->totalPag);
                }

                for ($i = $inicio; $i <= $fim; $i++) {
                    $tpl->pag = $i;
                    if ($this->pag == $tpl->pag) {
                        $tpl->link_pag  = $this->semLink;
                        $tpl->pag_atual = $this->classAtual;
                    } else {
                        $tpl->link_pag  = $this->link.$tpl->pag;
                        $tpl->pag_atual = '';
                    }

                    $tpl->block('PAGITEM');
                }
            }
            return $tpl->parse();
        }
    }

    public function show() {
        echo $this->getHtml();
    }
}