<style>
    .marginer {
        margin: 10px;
    }

    .badger-here {
        text-indent: -999em;
        top: 20px !important;
        right: 20px !important;
    }
</style>
<div class="header-dots">
    <div class="dropdown">
        <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="p-0 mr-2 btn" id="all_notif">
            <!-- <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                <span class="icon-wrapper-bg bg-danger"></span>
                <i class="pe-7s-bell icon text-danger ion-android-notifications"></i>
                <span class="badge badge-dot badge-dot-sm badge-danger">Notifications</span>
            </span> -->
        </button>
        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
            <div class="dropdown-menu-header mb-0 dropper">
                <div class="dropdown-menu-header-inner bg-deep-blue">
                    <div class="menu-header-content text-dark">
                        <h5 class="menu-header-title"></h5>
                        <h6 class="menu-header-subtitle"></h6>
                    </div>
                </div>
            </div>
            <div class="scroll-area-sm">
                <div class="scrollbar-container ps ps--active-y">
                    <div class="drophere marginer">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="header-btn-lg pr-0">
    <div class="widget-content p-0">
        <div class="widget-content-wrapper">
            <div class="widget-content-left">
                <div class="btn-group">
                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                        <?php
                        $src = base_url('assets/images/unk.png');
                        if ($this->session->userdata('loggedInPhoto') != null) {
                            $src = $this->session->userdata('loggedInPhoto');
                        }
                        ?>
                        <img width="32" class="rounded-circle" src="<?= $src ?>" alt="">
                        <span class="badge badge-dot badger-here badge-success">Online</span>
                        <!-- secondary -->
                        <!-- badge-dot-sm -->
                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                    </a>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                        <?php if ($this->session->userdata('loggedInRole') != 'Visitor') : ?>
                            <a href="<?= base_url('employee/emprofile?q=' . crmEncryptUrlParameter('eid=' . $this->session->userdata('loggedInEmpId'))) ?>" tabindex="0" class="dropdown-item">User Account</a>
                            <!-- <button type="button" tabindex="0" class="dropdown-item">Settings</button> -->
                        <?php endif; ?>
                        <a href="<?= base_url('login/logout') ?>" tabindex="0" class="dropdown-item">Log out</a>
                    </div>
                </div>
            </div>
            <div class="widget-content-left  ml-3 header-user-info">
                <div class="widget-heading">
                    <?php
                    $uname = $this->session->userdata('loggedInFullname');
                    if ($uname != null) {
                        echo $uname;
                    }
                    ?>
                </div>
                <div class="widget-subheading">
                    <?php
                    $rname = $this->session->userdata('loggedInRole');
                    if ($rname != null) {
                        echo $rname;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>