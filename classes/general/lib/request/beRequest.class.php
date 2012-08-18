<?php
class beRequest {

    public function isHomepage() {

        global $APPLICATION;

        return $APPLICATION->GetCurDir() == '/';

    }

}