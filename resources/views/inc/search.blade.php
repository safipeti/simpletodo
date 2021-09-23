<form method="GET">
    <div class="mb-3">
        <div class="row align-items-end">
            <div class="col-8">
                <label for="name" class="form-label">Keresett kifejezés:</label>
                <input type="text" name="search" class="form-control" id="name" placeholder="Keresett kifejezés"

                >
            </div>
            <div class="col-2">
                <button class="btn btn-primary">Keresés</button>
            </div>
            <div class="col-2">
                <a href="{{ route('todos.index') }}" class="btn btn-primary">Alaphelyzet</a>
            </div>
        </div>

    </div>
</form>
