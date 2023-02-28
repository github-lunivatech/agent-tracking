<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crystal</title>
    <style>
        body {
            /* overflow: hidden; */
            font-family: -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #292b2c;
            background-color: #fff;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        h4 {
            font-size: 1.5rem;
            margin-bottom: .5rem;
            font-family: inherit;
            font-weight: 500;
            line-height: 1.1;
            color: inherit;
            margin-top: 1.5rem;
        }
        .autoer {
            font-size: 0.9rem;
        }
        @media screen and (min-width: 842px){
            .top-header, .middle, .autoer, .jumbotron {
            display: flex;
            width: 50%;
            margin: auto;
        }
        .jumbotron {
            display: block;
        }
        .top-header div, .middle div{
            width: 50%;
        }    
        }
        .jumbotron {
            margin-bottom: 2rem;
            /* background-color: #eceeef; */
            border-radius: .3rem;
            text-align: center;
        }
        
        .middle {
            margin-bottom: 1.5rem;
        }
        .middle div {
            text-align: center;
        }
        img {
            width: 100%;
        }
        .bor {
            border-bottom: .05rem solid #e5e5e5;
            margin-bottom: 2rem;
        }
        .bor-up {
            border-top: .05rem solid #e5e5e5;
            padding-top: 1.5rem;
            color: #777;
        }
        .right-pull {
            float: right;
        }
        .c_logo {
            width: 170px;
        }
        .l_logo {
            width: 240px;
        }
        .btn {
            padding: .65rem 1.5rem;
            font-size: 1rem;
            border-radius: .3rem;
            display: inline-block;
    
            font-weight: 400;
            line-height: 1.25;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;            
            -webkit-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
            cursor: pointer;
        }

        .btn-req {
            color: #fff;
            background-color: #5cb85c;
            border-color: #5cb85c;
        }
        .btn-req:hover {
            color: #fff;
            background-color: #449d44;
            border-color: #419641;
        }

        .btn-log {
            color: #fff;
            background-color: #5bc0de;
            border-color: #5bc0de;
        }
        .btn-log:hover {
            color: #fff;
            background-color: #31b0d5;
            border-color: #2aabd2;
        }

    </style>
</head>
<body>

    <div class="top-header bor">
        <div>
            <a href="https://crystaldiagnosticlab.com/"><img src="<?= base_url('assets/images/cry.png') ?>" alt="" class="c_logo left-pull"></a>
        </div>
        <div>
            <a href="https://lunivacare.com/"><img src="<?= base_url('assets/images/logo.png') ?>" alt="" class="l_logo right-pull"></a>
        </div>
    </div>

    <div class="jumbotron">
        <a href="https://lunivacare.com/"><img src="<?= base_url('assets/images/hero.jpg') ?>" alt="" class="hero"></a>
    </div>

    <div class="middle">
        <div>
            <h4>Requestor</h4>
            <p>Click here for requestor login</p>
            <button class="btn btn-req">Requestor Login</button>
        </div>
        <div>
            <h4>Login</h4>
            <p>Click here for login</p>
            <button class="btn btn-log">Login</button>
        </div>
    </div>

    <footer class="autoer bor-up">
        &copy; Powered by LunivaTech.
    </footer>
</body>
</html>