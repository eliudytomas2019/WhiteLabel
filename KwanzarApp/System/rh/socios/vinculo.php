<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 29/08/2020
 * Time: 20:17
 */

if(!class_exists('login')):
    header("index.php");
    die();
endif;

if($level >= 4): $n =  '&id_db_settings='.$id_db_settings; else: $n = null; endif;

if($userlogin['level'] < 2):
    header("location: panel.php?exe=default/index".$n);
endif;
?>
<div class="container-fluid">
    <div class="styles">
        <a href="?exe=rh/socios/index<?= $n; ?>" class="btn btn-primary btn-sm">
            Voltar
        </a>&nbsp;
    </div>
</div>

<form id="formulario"  name="form_register" action="#getResult" method="post" enctype="application/x-www-form-urlencoded">
    <?php
    $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
    if ($ClienteData && $ClienteData['SendPostForm']):
    else:
        $ReadUser = new Read;
        $ReadUser->ExeRead("rh_vinculo", "WHERE id_socios=:userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
        if (!$ReadUser->getResult()):
        else:
            $ClienteData = $ReadUser->getResult()[0];
        endif;
    endif;
    ?>
    <div id="getResult"></div>

    <fieldset>
        <h2>Dados Financeiro</h2>

        <span>Capital% (ações)</span>
        <input type="text" name="capital" id="capital" placeholder="Capital %" value="<?php if (!empty($ClienteData['capital'])) echo $ClienteData['capital']; ?>"/>

        <span>Valor</span>
        <input type="text" name="valor" id="valor" placeholder="Valor" value="<?php if (!empty($ClienteData['valor'])) echo $ClienteData['valor']; ?>"/>

        <span>Data de Adimissão</span>
        <input type="datetime-local" name="admissao" id="admissao" placeholder="admissao" value="<?php if (!empty($ClienteData['admissao'])) echo $ClienteData['admissao']; ?>"/>

        <input type="submit" name="next" class="next acao" value="Próximo">
    </fieldset>

    <fieldset>
        <h2>Conclusão</h2>

        <span>Tipo</span>
        <select id="tipo" name="tipo">
            <option <?php if (!empty($ClienteData['tipo']) && $ClienteData['tipo'] == 'Sócio') echo 'selected'; ?>>Sócio</option>
            <option <?php if (!empty($ClienteData['tipo']) && $ClienteData['tipo'] == 'Acionista') echo 'selected'; ?>>Acionista</option>
            <option <?php if (!empty($ClienteData['tipo']) && $ClienteData['tipo'] == 'Sócio Presidente') echo 'selected'; ?>>Sócio Presidente</option>
        </select>

        <span>Status</span>
        <select id="status" name="status">
            <option <?php if (!empty($ClienteData['status']) && $ClienteData['status'] == 'Administrador') echo 'selected'; ?>>Administrador</option>
            <option <?php if (!empty($ClienteData['status']) && $ClienteData['status'] == 'Sem participação') echo 'selected'; ?>>Sem participação</option>
            <option <?php if (!empty($ClienteData['status']) && $ClienteData['status'] == 'Co-Fundador') echo 'selected'; ?>>Co-Fundador</option>
        </select>

        <input type="submit" name="prev" class="prev acao" value="Anterior">
        <a href="javascript:void()" name="next" class="acao" onclick="Vinculo(<?= $userId; ?>);">Finalizar</a>
    </fieldset>
</form>
