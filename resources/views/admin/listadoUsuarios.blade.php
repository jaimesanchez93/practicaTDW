
    <br><br><br>
<div class="btn-toolbar">
    <button class="btn btn-primary" id="btnCrearUser">Crear usuario</button>
    <button class="btn btn-primary" id="aaaaa" data-toggle='modal' data-target='#modalEditarJugador'>aaaa usuario</button>

</div>
<div id="principal" class="well">
    <table class="table" id="tablaUsuarios">
        <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th style="width: 36px;"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td  class="celdaId"></td>
            <td class="celdaNombre" ></td>
            <td class="celdaApellido"></td>
            <td class="celdaEmail"></td>
            <td>
                <a href="user.html"><i class="icon-pencil"></i></a>
                <a href="#myModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
            </td>
        </tr>

        </tbody>
    </table>
</div>
<div >
    <ul class="pagination">
        <li><a href="#">Prev</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">Next</a></li>
    </ul>
</div>
<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Confirmation</h3>
    </div>
    <div class="modal-body">
        <p class="error-text">Are you sure you want to delete the user?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" data-dismiss="modal">Delete</button>
    </div>
</div>



    <!-- VENTANA MODAL AÑADIR JUGADOR -->
    <div class="modal fade" id="modalEditarJugador" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Añadir un nuevo jugador</h4>
                </div>
                <div class="modal-body">
                    <p>Por favor, escriba su nombre</p>
                    <input type="text" id="nombre" value="" width="20px" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="crearJugador()" id="envioNombre" class="btn btn-success" data-dismiss="modal">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>