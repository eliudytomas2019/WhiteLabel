<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 23/06/2020
 * Time: 15:44
 */
?>
<section class="hero--area section-padding-80">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-12 col-md-7 col-lg-8">
                <div class="tab-content">
                    <?php
                    $idd = 0;
                    $read = new Read();
                    $read->ExeRead("ws_streaming", "ORDER BY id DESC LIMIT 1");

                    if($read->getResult()):
                        foreach($read->getResult() as $key):
                            extract($key);
                            $idd = $key['id'];
                            ?>
                            <div class="tab-pane fade show active" id="post-<?= $key['id']; ?>" role="tabpanel" aria-labelledby="post-1-tab">
                                <video class="single-feature-post video-post bg-img" controls>
                                    <source src="uploads/<?= $key['video']; ?>" type="video/mp4"/>
                                </video>
                            </div>
                            <?php
                        endforeach;
                    endif;

                    $read = new Read();
                    $read->ExeRead("ws_streaming", "WHERE id!={$idd} ORDER BY id DESC LIMIT 15");

                    if($read->getResult()):
                        foreach($read->getResult() as $key):
                            extract($key);
                            $idd = $key['id'];
                            ?>
                            <div class="tab-pane fade show" id="post-<?= $key['id']; ?>" role="tabpanel" aria-labelledby="post-1-tab">
                                <video class="single-feature-post video-post bg-img" controls>
                                    <source src="uploads/<?= $key['video']; ?>" type="video/mp4"/>
                                </video>
                            </div>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>

            <div class="col-12 col-md-5 col-lg-4">
                <ul class="nav vizew-nav-tab" role="tablist">
                    <?php
                        $read = new Read();
                        $read->ExeRead("ws_streaming", "ORDER BY id DESC LIMIT 1");

                        if($read->getResult()):
                            foreach($read->getResult() as $key):
                                extract($key);
                                $idd = $key['id'];
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link active" id="post-1-tab" data-toggle="pill" href="#post-<?= $key['id']; ?>" role="tab" aria-controls="post-1" aria-selected="true">
                                        <!-- Single Blog Post -->
                                        <div class="single-blog-post style-2 d-flex align-items-center">
                                            <video class="post-thumbnail">
                                                <source src="uploads/<?= $key['video']; ?>" type="video/mp4"/>
                                            </video>
                                            <div class="post-content">
                                                <h6 class="post-title"><?= $key['title']; ?></h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            endforeach;
                        endif;
                    ?>

                    <?php
                    $read = new Read();
                    $read->ExeRead("ws_streaming", "WHERE id!={$idd} ORDER BY id DESC LIMIT 15");

                    if($read->getResult()):
                        foreach($read->getResult() as $key):
                            extract($key);
                            $idd = $key['id'];
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" id="post-1-tab" data-toggle="pill" href="#post-<?= $key['id']; ?>" role="tab" aria-controls="post-1" aria-selected="true">
                                    <!-- Single Blog Post -->
                                    <div class="single-blog-post style-2 d-flex align-items-center">
                                        <video class="post-thumbnail">
                                            <source src="uploads/<?= $key['video']; ?>" type="video/mp4"/>
                                        </video>
                                        <div class="post-content">
                                            <h6 class="post-title"><?= $key['title']; ?></h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>
