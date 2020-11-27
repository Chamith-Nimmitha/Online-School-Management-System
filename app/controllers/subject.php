<?php

    class  Subject extends Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        // add new subjects to system
        public function subjectnew_add()
        {
            $this->view_header_and_aside();
            $this->load->view("subject/subjectnew-add");
            $this->load->view("templates/footer");
        }

        // view all subjects in the system
        public function subjectnew_view()
        {
            $this->view_header_and_aside();
            $this->load->view("subject/subjectnew-view");
            $this->load->view("templates/footer");
        }

        // update subjects in the system
        public function subjectnew_update()
        {
            $this->view_header_and_aside();
            $this->load->view("subject/subjectnew-update");
            $this->load->view("templates/footer");
        }
    }

?>