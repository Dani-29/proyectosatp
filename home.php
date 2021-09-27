<?php include 'db_connect.php' ?>


<body id="page-top">

    <div id="wrapper">

        <?php include 'includes/sidebar.php'?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
            <?php include 'includes/navbar.php'; ?>

                <div class="container-fluid">

                    <div class="col-lg-11 mb-8">
                            <div class="mb-8">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 20rem;"
                                            src="img/LOGO ISTPM.png" alt="...">
                                    </div>
                                
                            </div>
                        </div>

                    <div class="row">

                        <div class="col-lg-6 mb-4">
                            <div class="mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Misión</h6>
                                </div>
                                <div class="card-body">
                                    <p>Somos una Institución plural, comprometida con la formación de profesionales capaces, 
                                        íntegros y competitivos, que contribuyen al desarrollo de la sociedad mediante la ciencia y la tecnología.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Visión</h6>
                                </div>
                                <div class="card-body">
                                    <p>Al año 2021, el Instituto Tecnológico Superior Primero de Mayo se consolida como 
                                        una de las más importantes instituciones de educación superior de la región; para ello, 
                                        trabaja en el mejoramiento continuo de sus procesos académicos y administrativos, 
                                        con una clara vinculación al desarrollo social y económico de Zamora Chinchipe y del país.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <?php include 'includes/footer.php'?>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>


</body>





<script>
	$('#manage-records').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status==1){
                    alert_toast("Datos guardados con éxito",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })
    $('#check').on('click',function(e){
            get_person()
    })
    function get_person(){
            start_load()
        $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status == 2){
                            alert_toast("ID de seguimiento desconocido.",'danger');
                            end_load();
                        }
                    }
                }
            })
    }
</script>