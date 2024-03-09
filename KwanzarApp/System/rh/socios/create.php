<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 29/08/2020
 * Time: 00:33
 */
?>

<div class="container-fluid">
    <div class="styles">
        <a href="?exe=rh/socios/index<?= $n; ?>" class="btn btn-primary btn-sm">
            Voltar
        </a>&nbsp;
    </div>
</div>

<form id="formulario"  name="form_register" action="#getResult" method="post" enctype="application/x-www-form-urlencoded">
    <div id="getResult"></div>

    <fieldset>
        <h2>Dados Pessoal</h2>

        <span>Nome completo</span>
        <input type="text" name="nome" id="nome" placeholder="NOME COMPLETO"/>

        <span>BI, Passaporte ou NIF</span>
        <input type="text" name="nif" id="nif" placeholder="NIF OU BI"/>

        <span>Sexo</span>
        <select id="sexo" name="sexo">
            <option selected>Masculino</option>
            <option>Femenino</option>
        </select>
        <span>Data de nascimento</span>
        <input type="date" name="data_nascimento" id="data_nascimento" placeholder="DATA DE NASCIMENTO"/>

        <span>Nacionalidade</span>
        <select id="nacionalidade" name="nacionalidade">
            <?php
                $read->ExeRead("rh_nacionalidade", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
                if($read->getResult()):
                    foreach($read->getResult() as $key):
                        ?>
                        <option><?= $key['nacionalidade']; ?></option>
                        <?php
                    endforeach;
                endif;
            ?>
        </select>

        <input type="submit" name="next" class="next acao" value="Próximo">
    </fieldset>

    <fieldset>
        <h2>Dados conjulgas e Etnia</h2>

        <span>Estado cívil</span>
        <select id="estado_civil" name="estado_civil">
            <option selected>Solteiro/a</option>
            <option>Casado/a</option>
            <option>Divorciado/a</option>
            <option>Viúvo/a</option>
        </select>

        <span>Regime matrimônial</span>
        <select id="regime_matrimonial" name="regime_matrimonial">
            <option selected>Nenhum</option>
            <option>comunhão de bens</option>
            <option>comunhão parcial de bens</option>
            <option>separação de bens</option>
        </select>

        <span>Raça/Cor da pel</span>
        <select id="raca_cor" name="raca_cor">
            <option>Branco/a</option>
            <option>Pardo/a</option>
            <option selected>Negro/a</option>
            <option>Amarelo/a</option>
            <option>Indígina</option>
        </select>

        <span>Dificiência</span>
        <select id="dificiencia" class="dificiencia">
            <option selected>Nenhuma</option>
            <?php
            $read->ExeRead("rh_dificiencia", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    ?>
                    <option><?= $key['dificiencia']; ?></option>
                    <?php
                endforeach;
            endif;
            ?>
        </select>

        <span>Grau Acadêmico</span>
        <select name="grau_instrucao" id="grau_instrucao">
            <?php
            $read->ExeRead("rh_grau", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    ?>
                    <option><?= $key['grau']; ?></option>
                    <?php
                endforeach;
            endif;
            ?>
        </select>

        <input type="submit" name="prev" class="prev acao" value="Anterior">
        <input type="submit" name="next" class="next acao" value="Próximo">
    </fieldset>

    <fieldset>
        <h2>Origens & Herdeiro</h2>

        <span>Nome do pai</span>
        <input type="text" name="nome_pai" id="nome_pai" placeholder="Nome do pai"/>
        <span>Nome da mãe</span>
        <input type="text" name="nome_mae" id="nome_mae" placeholder="Nome da mãe"/>
        <span>Nome do cônjuge</span>
        <input type="text" name="nome_conjuge" id="nome_conjuge" placeholder="Nome do cônjuge"/>
        <span>País de nacionalidade</span>
        <select name="pais_nacionalidade" id="pais_nacionalidade">
            <?php
            $read->ExeRead("rh_nacionalidade", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    ?>
                    <option><?= $key['pais']; ?></option>
                    <?php
                endforeach;
            endif;
            ?>
        </select>
        <span>Herdeiro legal</span>
        <input type="text" name="herdeiro_legal" id="herdeiro_legal" placeholder="Herdeiro legal"/>

        <input type="submit" name="prev" class="prev acao" value="Anterior">
        <input type="submit" name="next" class="next acao" value="Próximo">
    </fieldset>

    <fieldset>
        <h2>Conclusão</h2>

        <span>Telefone</span>
        <input type="text" name="telefone" id="telefone" placeholder="Telefone"/>
        <span>Email</span>
        <input type="text" name="email" id="email" placeholder="Email"/>
        <span>Endereço</span>
        <input type="text" name="endereco" id="endereco" placeholder="Endereço"/>
        <span>Profissão</span>
        <input type="text" name="profissao" id="profissao" placeholder="Profissão"/>
        <span>Observações</span>
        <textarea id="descricao" name="descricao" placeholder="Observações"></textarea>

        <input type="submit" name="prev" class="prev acao" value="Anterior">
        <a href="javascript:void()" name="next" class="acao" onclick="Socios();">Finalizar</a>
    </fieldset>
</form>