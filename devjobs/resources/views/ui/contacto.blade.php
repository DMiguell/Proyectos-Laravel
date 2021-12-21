<aside class="md-w-2/5 bg-teal-500 p-5 rounded m-3">
    <h2 class="text-2xl my-5 text-white uppercase font-bold text-center">Contacta al reclutador</h2>
    <form enctype="multipart/form-data" action="{{route('candidatos.store')}} " method="POST">
        @csrf
        <div class="mb-4">
            <label for="nombrre" class="text-white block text-sm font-bold mb-4">
                Nombre:
            </label>
            <input type="text" 
            id="nombre" 
            class="p-3 bg-gray-100 rounded w-full form-input @error ('nombre') border border-red-500 @enderror 
            " 
            name="nombre" 
            placeholder="Tu Nombre" 
            value="{{old('nombre')}}">
            @error('nombre')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-500 p-4 w-full mt-5">
                    <p>{{$message}}</p>
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="text-white block text-sm font-bold mb-4">
                Email:
            </label>
            <input type="text" 
            id="email" 
            class="p-3 bg-gray-100 rounded w-full form-input @error ('email') border border-red-500 @enderror 
            " 
            name="email" 
            placeholder="Tu Email" 
            value="{{old('email')}}">
            @error('email')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-500 p-4 w-full mt-5">
                    <p>{{$message}}</p>
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="cv" class="text-white block text-sm font-bold mb-4">
                Curriculum (PDF):
            </label>
            <input type="file" 
            id="cv" 
            class="p-3  rounded w-full form-input @error ('cv') border border-red-500 @enderror 
            " 
            name="cv" 
            placeholder="Tu CV" 
            accept="application/pdf">
            @error('cv')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-500 p-4 w-full mt-5">
                    <p>{{$message}}</p>
                </div>
            @enderror
        </div>
        <input type="hidden" name="vacante_id" value="{{$vacante->id}}">
        <input type="submit" name="" id="" value="Contactar" class="bg-teal-600 w-full hover:bg-teal-700 text-gray-100 p-3 focus:outline-none focus:shadow-outline uppercase">
    </form>
</aside>