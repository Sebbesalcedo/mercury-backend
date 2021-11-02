<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="./style/cumpleanos.css"> --}}
    <title>Feliz Cumpleaños</title>
</head>

<style>
    body { font-family: "Gill Sans Extrabold", Helvetica, sans-serif ;
    align-items: center;
    display: flex;

    justify-content: center;

  }

  .imga{
    background-image: url('../img/3494485.jpg');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    width: 60%;

  }
  .cuadro{
     background: rgba( 255, 255, 255, 0.25 );
  box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
  backdrop-filter: blur( 2px );
  -webkit-backdrop-filter: blur( 4px );
  border-radius: 10px;
  border: 1px solid rgba( 255, 255, 255, 0.18 );
  text-align: center;



    color: #333;
  }
  .f_cabecera{

    -webkit-text-stroke: 2px    #474947 ;
    color: #68e63f;
    font-size: 60px;

  }
  .nPersonas{
    font-style: italic;
    -webkit-text-stroke: 2px    #474947 ;
    color: #e6d53f;
    font-size: 70px;
  }
  .f_footter{
    -webkit-text-stroke: 2px    #474947 ;
    color: #68e63f;
    font-size: 55px;
  }
</style>
<body>
        <div class="imga" >

            <div class="cuadro">
                <section>
                    <img src="data:image/png;base64,{{base64_encode(file_get_contents(resource_path('./img/encord2.png')))}}" alt="">
                    <img src="./img/encord2.png" style="width: 40%;">
                </section>
               <br>
                <section>
                    <h1 class="f_cabecera">Feliz cumpleaños</h1>
                </section>
                <section>
                    <p class="nPersonas">Nombre de la persona</p>
                </section>

                <section>
                    <h2 class="f_footter">Te desea la familia Encord</h2>
                </section>

            </div>
        </div>


</body>
</html>

