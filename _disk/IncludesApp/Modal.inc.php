<div class="modal modal-blur fade" id="modal-horario-users" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Horário e Agenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="getResult2023"></div>
                <form method="post" action="#" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-3">
                            <span>Hora de Entrada</span>
                            <input type="time" class="form-control" name="hora_i" id="hora_i"/>
                        </div>
                        <div class="col-lg-3">
                            <span>Hora de Saída</span>
                            <input type="time" class="form-control"  name="hora_f" id="hora_f"/>
                        </div>
                        <div class="col-lg-6">
                            <span>Dia da Semana</span>
                            <select name="dia_da_semana" id="dia_da_semana" class="form-control">
                                <option>-- Selecione o dia da semana --</option>
                                <option value="Monday">Segunda-feira</option>
                                <option value="Tuesday">Terça-feira</option>
                                <option value="Wednesday">Quarta-feira</option>
                                <option value="Thursday">Quinta-feira</option>
                                <option value="Friday">Sexta-feira</option>
                                <option value="Saturday">Sábado</option>
                                <option value="Sunday">Domingo</option>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <br/><div class="col-lg-12">
                        <button type="button" onclick="ClinicHorario(<?= $id_userX; ?>, <?= $id_db_settings; ?>);" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>