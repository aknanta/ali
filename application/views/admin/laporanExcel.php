<?php
header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=data absensi.xlsx");
?>

<table border="1" width="100%">
    <thead>
        <tr>
            <th>NIK</th>
            <th>Tanggal Input Absensi</th>
            <th>ID Posisi</th>
            <th>Shift</th>
            <th>Total Jam Kerja</th>
            <th>Lembur</th>
        </tr>
    </thead>

    <tbody>


        <?php if (!empty($user)) :
            foreach ($user as $a) : ?>
                <tr>
                    <td><?php echo $a->nik ?></td>
                    <td><?php echo $a->tgl_input_absensi ?></td>
                    <td><?php echo $a->id_posisi ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        <?php endforeach;
        endif; ?>
    </tbody>
</table>