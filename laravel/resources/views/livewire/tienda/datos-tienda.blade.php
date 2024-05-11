<div>
    <style>
        .containers {
            margin: 50px auto;
            background-color: rgb(238, 238, 238);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }
        .store-image {
            width: 300px; /* Tamaño de la imagen de la tienda */
            margin-right: 30px; /* Espacio entre la imagen y el texto */
            border-radius: 5000px;
        }
        .store-info {
            flex-grow: 1; /* Para que ocupe el espacio restante */
        }
        h1 {
            font-size: 86px;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }
        .slogan {
            font-size: 16px;
            color: #999;
            margin-top: 10px;
        }
        .store-type {
            font-size: 16px;
            color: #999;
            margin-bottom: 10px;
        }

        .slider-container {
            max-width: 800px;
            margin: 50px auto;
            overflow: hidden;
        }
        .slider {
            display: flex;
            transition: transform 0.5s ease;
        }
        .card {
            flex: 0 0 300px;
            margin-right: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }
        .card-content {
            padding: 20px;
        }
        .card-content h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }
        .card-content p {
            font-size: 16px;
            color: #666;
        }
    </style>
    <div class="containers">
        <img src="../../dist/img/tienda.jpeg" alt="Imagen de la Tienda" class="store-image">
        <div class="store-info">
            <p class="store-type">{{$store->type}}</p>
            <h1>{{$store->name}}</h1>
            <p class="slogan">{{$store->slogan}} | {{$store->telefono}}</p>
            <div class="mt-3">
                <a href="" class="btn " 
                    style="border-radius: 16px; color: black; border-color: #213869bb">
                    Editar Datos
                    <i class="fa-solid fa-pills"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="slider-container">
        <div class="slider">
            <!-- Card 1 -->
            <div class="card">
                <img src="ruta_de_la_imagen_1" alt="Sucursal 1">
                <div class="card-content">
                    <h2>Sucursal 1</h2>
                    <p>Dirección: Dirección de la Sucursal 1</p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="card">
                <img src="ruta_de_la_imagen_2" alt="Sucursal 2">
                <div class="card-content">
                    <h2>Sucursal 2</h2>
                    <p>Dirección: Dirección de la Sucursal 2</p>
                </div>
            </div>
            <!-- Añade más cards según sea necesario -->
        </div>
    </div>

    <script>
        // Script para desplazarse por el slider
        const slider = document.querySelector('.slider');
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2; // Controla la velocidad del desplazamiento
            slider.scrollLeft = scrollLeft - walk;
        });
    </script>
</div>
