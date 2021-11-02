<?php
$mailable = new NotificacionAsistenciaAlumno($alumno, $fecha);
Mail::to("ejemplo@gmail.com")->send($mailable);
