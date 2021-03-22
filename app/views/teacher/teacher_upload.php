<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
<div class="registration-form col-5 justify-content-center">
    <?php
        if(isset($info) && !empty($info))
        {
            echo "<p class='w-75 bg-green p-2 text-center'>";
            echo $info;
            echo "</p";
        }
        if(isset($error) && !empty($error))
        {
            echo "<p class='w-75 bg-red p-2 text-center'>";
            echo $error;
            echo "</p>";
        }
    ?>

    <div class="mt-5  w-75 d-flex flex-col align-items-center">
        <h2 class="pt-3 pb-3">Teacher Upload</h2>
        <hr class="topic-hr w-100">
    </div>

    <form method="POST" action="<?php set_url("teacher/csv")?>" class="col-12 align-items-start" enctype="multipart/form-data">
        <div class="ml-5 align-items-center">
            <label>Select CSV File:</label>
            <input type="file" name="file">
        </div>
        <div class="ml-5 align-items-center">
            <button type="submit" name="submit" id="submit" class="btn btn-blue w-auto m-1">Import</button>
        </div>
    </form>

</div>

    <div class="container mt-12 col-5 table table-strip-dark text-center">
        <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>NIC</th>
            </tr>
        </thead>
        <tbody id="tbody">
            <?php
                if(isset($result_set) && !empty($result_set))
                {
                    foreach($result_set as $result)
                    {
                        ?>
                            <tr>
                                <td><?php echo $result['$dataset[0]'];?></td>
                                <td><?php echo $result['$dataset[1]'];?></td>
                                <td><?php echo $result['$dataset[2]'];?></td>
                                <td><?php echo $result['$dataset[3]'];?></td>
                            </tr>
                        <?php
                    }
                }
                else
                {
                    echo "<tr><td colspan=8 class='text-center bg-red'>Teachers not found...</td></tr>";
                }
            ?>
        </tbody>
        </table>
    </div>
</div>