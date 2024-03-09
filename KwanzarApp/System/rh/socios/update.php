<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 29/08/2020
 * Time: 12:26
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
    <div id="getResult">
        <?php
        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $userId = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
        if ($ClienteData && $ClienteData['SendPostForm']):
        else:
            $ReadUser = new Read;
            $ReadUser->ExeRead("rh_socios", "WHERE id = :userid AND id_db_settings=:i", "userid={$userId}&i={$id_db_settings}");
            if (!$ReadUser->getResult()):

            else:
                $ClienteData = $ReadUser->getResult()[0];
            endif;
        endif;
        ?>
    </div>

    <fieldset>
        <h2>Dados Pessoal</h2>

        <span>Nome completo</span>
        <input type="text" name="nome" id="nome" placeholder="NOME COMPLETO" value="<?php if (!empty($ClienteData['nome'])) echo $ClienteData['nome']; ?>"/>

        <span>BI, Passaporte ou NIF</span>
        <input type="text" name="nif" id="nif" placeholder="NIF OU BI" value="<?php if (!empty($ClienteData['nif'])) echo $ClienteData['nif']; ?>"/>

        <span>Sexo</span>
        <select id="sexo" name="sexo">
            <option <?php if (!empty($ClienteData['sexo']) && $ClienteData['sexo'] == "Masculino") echo 'selected'; ?>>Masculino</option>
            <option <?php if (!empty($ClienteData['sexo']) && $ClienteData['sexo'] == "Femenino") echo 'selected'; ?>>Femenino</option>
        </select>
        <span>Data de nascimento</span>
        <input type="date" value="<?php if (!empty($ClienteData['data_nascimento'])) echo $ClienteData['data_nascimento']; ?>" name="data_nascimento" id="data_nascimento" placeholder="DATA DE NASCIMENTO"/>

        <span>Nacionalidade</span>
        <select id="nacionalidade" name="nacionalidade">
            <?php
            $read->ExeRead("rh_nacionalidade", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    ?>
                    <option <?php if (!empty($ClienteData['nacionalidade']) && $ClienteData['nacionalidade'] == $key['nacionalidade']) echo 'selected'; ?>><?= $key['nacionalidade']; ?></option>
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
            <option <?php if (!empty($ClienteData['estado_civil']) && $ClienteData['estado_civil'] == "Solteiro/a") echo 'selected'; ?>>Solteiro/a</option>
            <option <?php if (!empty($ClienteData['estado_civil']) && $ClienteData['estado_civil'] == "Casado/a") echo 'selected'; ?>>Casado/a</option>
            <option <?php if (!empty($ClienteData['estado_civil']) && $ClienteData['estado_civil'] == "Divorciado/a") echo 'selected'; ?>>Divorciado/a</option>
            <option <?php if (!empty($ClienteData['estado_civil']) && $ClienteData['estado_civil'] == "Viúvo/a") echo 'selected'; ?>>Viúvo/a</option>
        </select>

        <span>Regime matrimônial</span>
        <select id="regime_matrimonial" name="regime_matrimonial">
            <option <?php if (!empty($ClienteData['regime_matrimonial']) && $ClienteData['regime_matrimonial'] == "Nenhum") echo 'selected'; ?>>Nenhum</option>
            <option <?php if (!empty($ClienteData['regime_matrimonial']) && $ClienteData['regime_matrimonial'] == "comunhão de bens") echo 'selected'; ?>>comunhão de bens</option>
            <option <?php if (!empty($ClienteData['regime_matrimonial']) && $ClienteData['regime_matrimonial'] == "comunhão parcial de bens") echo 'selected'; ?>>comunhão parcial de bens</option>
            <option <?php if (!empty($ClienteData['regime_matrimonial']) && $ClienteData['regime_matrimonial'] == "separação de bens") echo 'selected'; ?>>separação de bens</option>
        </select>

        <span>Raça/Cor da pel</span>
        <select id="raca_cor" name="raca_cor">
            <option <?php if (!empty($ClienteData['raca_cor']) && $ClienteData['raca_cor'] == 'Branco/a') echo 'selected'; ?>>Branco/a</option>
            <option <?php if (!empty($ClienteData['raca_cor']) && $ClienteData['raca_cor'] == 'Pardo/a') echo 'selected'; ?>>Pardo/a</option>
            <option <?php if (!empty($ClienteData['raca_cor']) && $ClienteData['raca_cor'] == 'Negro/a') echo 'selected'; ?>>Negro/a</option>
            <option <?php if (!empty($ClienteData['raca_cor']) && $ClienteData['raca_cor'] == 'Amarelo/a') echo 'selected'; ?>>Amarelo/a</option>
            <option <?php if (!empty($ClienteData['raca_cor']) && $ClienteData['raca_cor'] == 'Indígina') echo 'selected'; ?>>Indígina</option>
        </select>

        <span>Dificiência</span>
        <select id="dificiencia" class="dificiencia">
            <option <?php if (!empty($ClienteData['dificiencia']) && $ClienteData['dificiencia'] == "Nenhuma") echo 'selected'; ?>>Nenhuma</option>
            <?php
            $read->ExeRead("rh_dificiencia", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    ?>
                    <option <?php if (!empty($ClienteData['dificiencia']) && $ClienteData['dificiencia'] == $key['dificiencia']) echo 'selected'; ?>><?= $key['dificiencia']; ?></option>
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
                    <option <?php if (!empty($ClienteData['grau_instrucao']) && $ClienteData['grau_instrucao'] == $key['grau']) echo 'selected'; ?>><?= $key['grau']; ?></option>
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
        <input type="text" name="nome_pai" id="nome_pai" value="<?php if (!empty($ClienteData['nome_pai'])) echo $ClienteData['nome_pai']; ?>" placeholder="Nome do pai"/>
        <span>Nome da mãe</span>
        <input type="text" name="nome_mae" id="nome_mae" value="<?php if (!empty($ClienteData['nome_mae'])) echo $ClienteData['nome_mae']; ?>" placeholder="Nome da mãe"/>
        <span>Nome do cônjuge</span>
        <input type="text" name="nome_conjuge" id="nome_conjuge" value="<?php if (!empty($ClienteData['nome_conjuge'])) echo $ClienteData['nome_conjuge']; ?>" placeholder="Nome do cônjuge"/>
        <span>País de nacionalidade</span>
        <select name="pais_nacionalidade" id="pais_nacionalidade">
            <?php
            $read->ExeRead("rh_nacionalidade", "WHERE id_db_settings=:i ORDER BY id ASC", "i={$id_db_settings}");
            if($read->getResult()):
                foreach($read->getResult() as $key):
                    ?>
                    <option <?php if (!empty($ClienteData['pais_nacionalidade']) && $ClienteData['pais_nacionalidade'] == $ClienteData['pais_nacionalidade']) echo 'selected'; ?>><?= $key['pais']; ?></option>
                    <?php
                endforeach;
            endif;
            ?>
        </select>
        <span>Herdeiro legal</span>
        <input type="text" name="herdeiro_legal" value="<?php if (!empty($ClienteData['herdeiro_legal'])) echo $ClienteData['herdeiro_legal']; ?>" id="herdeiro_legal" placeholder="Herdeiro legal"/>

        <input type="submit" name="prev" class="prev acao" value="Anterior">
        <input type="submit" name="next" class="next acao" value="Próximo">
    </fieldset>

    <fieldset>
        <h2>Conclusão</h2>

        <span>Telefone</span>
        <input type="text" name="telefone" id="telefone" value="<?php if (!empty($ClienteData['telefone'])) echo $ClienteData['telefone']; ?>" placeholder="Telefone"/>
        <span>Email</span>
        <input type="text" name="email" id="email" value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>" placeholder="Email"/>
        <span>Endereço</span>
        <input type="text" name="endereco" id="endereco" value="<?php if (!empty($ClienteData['endereco'])) echo $ClienteData['endereco']; ?>" placeholder="Endereço"/>
        <span>Profissão</span>
        <input type="text" name="profissao" id="profissao" value="<?php if (!empty($ClienteData['profissao'])) echo $ClienteData['profissao']; ?>" placeholder="Profissão"/>
        <span>Observações</span>
        <textarea id="descricao" name="descricao" placeholder="Observações"><?php if (!empty($ClienteData['descricao'])) echo $ClienteData['descricao']; ?></textarea>

        <input type="submit" name="prev" class="prev acao" value="Anterior">
        <a href="javascript:void()" name="next" class="acao" onclick="Socios();">Finalizar</a>
    </fieldset>
</form>
