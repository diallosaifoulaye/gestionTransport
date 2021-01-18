<style>
    .param {
        margin-bottom: 7px;
        line-height: 1.4;
        font-size: 19px;
    }
    .param-inline dt {
        display: inline-block;
    }
    .param dt {
        margin: 0;
        margin-right: 40px;
        font-weight: 600;
        color: black;
    }
    .param-inline dd {
        vertical-align: baseline;
        display: inline-block;
    }

    .param dd {
        margin: 0;
        margin-right: 40px;
        vertical-align: baseline;
    }

    .shopping-cart-wrap .price {
        color: #007bff;
        font-size: 18px;
        font-weight: bold;
        margin-right: 5px;
        display: block;
    }
    var {
        font-style: normal;
    }

    .media img {
        margin-right: 1rem;
    }
    .img-sm {
        width: 90px;
        max-height: 75px;
        object-fit: cover;
    }
</style>

<div id="page-wrapper">

    <div class="container-fluid">

        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['detail_facture']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="#">  <?php echo $this->lang['facture']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['detail_facture']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>


        <div class="row">

            <div class="white-box">
                <div class="col-lg-12">
                     <a href="<?= WEBROOT?>facturation/exportRecuDetail" target="_blank" class="btn btn-plus pull-right m-l-20  waves-effect waves-light" >
                         <?= $this->lang['exporter_pdf']; ?><i class="fa fa-file-pdf-o"></i>
                            </a>
                </div>
                <div class="tab-content">

                        <br/><br/>

                        <table class="table table-bordered table-hover table-responsive processing"
                               data-url="<?= WEBROOT; ?>facturation/detailFactureProcess/<?php echo $id ?>">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang['service']; ?></th>
                                <th class="text-center"><?php echo $this->lang['transactions']; ?></th>
                                <th class="text-center"><?php echo $this->lang['montant']; ?></th>
                                <th class="text-center"><?php echo $this->lang['part_nta']; ?></th>
                                <th class="text-center"><?php echo $this->lang['part_numherit']; ?></th>
                            </tr>
                            </thead>
                        </table>






                </div>


                    </div>

                </div>
            </div>


        </div>

