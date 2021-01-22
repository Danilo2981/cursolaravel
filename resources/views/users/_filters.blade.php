<form method="get" action="{{ url('usuarios') }}">
    <div class="row row-cols-md-auto gx-0 align-items-center">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
            <label class="form-check-label" for="inlineCheckbox1">Todos</label>
            </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
            <label class="form-check-label" for="inlineCheckbox1">Activos</label>
            </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
            <label class="form-check-label" for="inlineCheckbox1">Inactivos</label>
        </div>
    </div>
    <div class="row row-cols-sm-auto gx-1 align-items-center justify-content-between">
        <div class="row row-cols-sm-auto gx-1 align-items-center">
            <div class="col-12">
                <div class="input-group">
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm me-1" id="inlineFormInputGroupUsername" placeholder="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-sm" type="submit">Search</button>
                    </div>
                </div>    
            </div>
            <div class="col-12">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-success dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                        Rol
                    </button>     
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Todos</a></li>
                        <li><a class="dropdown-item" href="#">Usuario</a></li>
                        <li><a class="dropdown-item" href="#">Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-success dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                        Habilidades
                    </button>
                    <div class="dropdown-menu skills-list">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="skill1">
                            <label class="form-check-label" for="skill1">CSS</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="skill2">
                            <label class="form-check-label" for="skill2">Laravel Development</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="skill3">
                            <label class="form-check-label" for="skill3">Front End</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="skill4">
                            <label class="form-check-label" for="skill4">Bases de Datos</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="skill5">
                            <label class="form-check-label" for="skill5">Javascript</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-sm-auto gx-1 align-items-center">
            <div class="col-12">
                <label for="date_start" class="form-label-sm">Fecha</label>
            </div> 
            <div class="col-12">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="date_start" id="date_start" placeholder="Desde">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-secondary btn-sm"><span class="fas fa-calendar-alt"></span></button>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="date_start" id="date_start" placeholder="Hasta">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-secondary btn-sm"><span class="fas fa-calendar-alt"></span></button>
                    </div>
                </div> 
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-sm btn-outline-success">Filtrar</button>
            </div>
        </div>        
    </div>    
</form>