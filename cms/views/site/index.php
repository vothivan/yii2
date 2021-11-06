<?php

use yii\helpers\Url;

?>

<script type="text/javascript" src="//kjur.github.io/jsrsasign/jsrsasign-4.1.4-all-min.js"></script>
<script type="text/javascript" src="//kjur.github.io/jsjws/ext/json-sans-eval-min.js"></script>
<script type="text/javascript" src="//kjur.github.io/jsjws/jws-3.2.js"></script>

<script>
    (function (w, d, s, g, js, fs) {
        g = w.gapi || (w.gapi = {});
        g.analytics = {
            q: [], ready: function (f) {
                this.q.push(f);
            }
        };
        js = d.createElement(s);
        fs = d.getElementsByTagName(s)[0];
        js.src = 'https://apis.google.com/js/platform.js';
        fs.parentNode.insertBefore(js, fs);
        js.onload = function () {
            g.load('analytics');
        };
    }(window, document, 'script'));
</script>
<section class="content-header">
    <h1>
        Hệ thống quản trị
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= Url::home() ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Khách ghé thăm mới</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="chartNew"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Nguồn truy cập</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="chartSource"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Truy cập theo khu vực</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="chartGeo"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Truy cập tháng qua</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="chartVisit"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Nội dung được quan tâm nhất</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="chartContent"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>

<script>



// {
//   "type": "service_account",
//   "project_id": "banh-loc-phuong-thu",
//   "private_key_id": "d44d052f59e6340271579244ab588d9db9f3a3db",
//   "private_key": "",
//   "client_email": "banhlocphuongthu@banh-loc-phuong-thu.iam.gserviceaccount.com",
//   "client_id": "105256761942426729063",
//   "auth_uri": "https://accounts.google.com/o/oauth2/auth",
//   "token_uri": "https://oauth2.googleapis.com/token",
//   "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
//   "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/banhlocphuongthu%40banh-loc-phuong-thu.iam.gserviceaccount.com"
// }


    
    var pHeader = {"alg": "RS256", "typ": "JWT"}
    var sHeader = JSON.stringify(pHeader);
    var pClaim = {};
    pClaim.aud = "https://www.googleapis.com/oauth2/v3/token";
    pClaim.scope = "https://www.googleapis.com/auth/analytics.readonly";
    pClaim.iss = "banhlocphuongthu@banh-loc-phuong-thu.iam.gserviceaccount.com";
    pClaim.exp = KJUR.jws.IntDate.get("now + 1hour");
    pClaim.iat = KJUR.jws.IntDate.get("now");

    var sClaim = JSON.stringify(pClaim);
    var key = "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCa3NUlGM5n2pFn\nH5xt7yj3Io7PDcepOYWbKO6uvZLTUS7o0gYe+PT7KnwBXGsAJO8GnVPhXus2DTTq\n+g4E/RydhJtmEBOwXQhSJ2D0y07DXQpr4Aq+AS8G3yy07LWepNY2+tJDy9/c1HrP\ntSPrRUExqKT0E0B+FP54CExxQcAar7K8JCS2D4KzHiVlJDwpaEoSNiIpCzMhrtUm\n4lvbIB6MZ8CkIDcpg8PyPrk/FzfGgYNtmZjWn6opQ/pCAkwj6Hx7e5mVzdCahkec\nRl/TL+z4cPHZcbsZyViM0SFtR4y88911hjcXwvDxEbH8z2mxWX80dMsv6XHYcKJf\nbRo/RKKFAgMBAAECggEAHYFesNs5lErt8iZxMPbkqLVyXRvEg0b84DObyjo/S7jH\nhb9iQCtxzZrqFn5LurLOwcVe8m0Zxmocv3pWCnhJJ+/YhckhXzRSfgiXrfxAbPOA\npU4B7fKeyaHizDPfZLMGR2Jhhl5FMDdhkMpz5gMDaVk22HQEkSEh3K/EFL4QwmSU\nXC30tqf/VG18HWC40OMMJzi5ff6WrpoGKzZvfJk3HWDfWhzHnGa9EKl7oucNSN+5\nNkQFh/ahK263IeeN/6yCZGKMTXuesTiB30ofkh/KAMA1soHuJUHTDNFT2c6D8/EK\nsgXjUEn/iEOwSPY0+FnbUvirGWH+7QUQ+2zpa9SfPwKBgQDSu07g/r9R2IawdKnK\nrhrsEwXxe7h2O9AJH8v9nJowJHs41FUfdB3xiaO13zzuEweRY7CrnBbym4xiOn5T\nE9TmUbqvc//eFh3BnQtmZcUELXINalml7N9onOE0dOS3nH0D5pMlk/8g5X98PPvv\nShnZePzaWkUpV3rPxnPBPBWoxwKBgQC8ISNRgF+ZNhizkOPxfqrYivlvTn0nN9gJ\nNiM9SU2bhizUrK5DE8Bui3KrShC3nVV4a5PJEswv1AA4q+M6U6GC5Kw+nEkun11R\nLWlaYIEPLrF3kClSZrhglVc7hX6rSwbdRJjFI/402U477Xlp4z0nHVXtH2LQRMQg\nGyeQC6PGUwKBgHXgJoA+n2A14SmFKJDiENcq0PFCRm2EiZsA+UdUuP7i+TZRt4fP\nmQxJ9JRAWkHFzT7rZ6CmwENW9RDhLVZlSnrHDskj9uUQs/ZgVUci+DCdByYv7hOd\nS16mGmcQV/vJAjkTWg30GgsZtNUW+8nfRlRak/3D7tnwQBdHJ+rYJDlzAoGAYxKM\nd/JD5fqAHahS8i2DqU/etgg+jnWxNoClJDRDQ4DwgPuDNd3j/BNBywTRMvEPPsBg\nboaQsytRBoc2vdOm/biRINPLEltomERy895YePddDBsGN9fSh0J+UuElaO206rei\nQEeJKqm5soOH6gR6guvHAX4C2q0sH8BNIGWQ1PMCgYAbS97OgF6fssNjWfo3giwp\nv8O43EYlwyX2MLfkT6GJd+EGRr1YW8LxFjB/aNm4Nv0qAMajR2g6k+asFr7v61gY\nQGq4KD1zZJ32dAhrOB+M3L6/bn6adzQW9E8injGzP3ZVSjtS+duAOCu3lnr4Lhyt\nzxv9S8qToikc3j1nRH3qyA==\n-----END PRIVATE KEY-----\n";
    var sJWS = KJUR.jws.JWS.sign(null, sHeader, sClaim, key);
    var XHR = new XMLHttpRequest();
    var urlEncodedData = "";
    var urlEncodedDataPairs = [];

    urlEncodedDataPairs.push(encodeURIComponent("grant_type") + '=' + encodeURIComponent("urn:ietf:params:oauth:grant-type:jwt-bearer"));
    urlEncodedDataPairs.push(encodeURIComponent("assertion") + '=' + encodeURIComponent(sJWS));
    urlEncodedData = urlEncodedDataPairs.join('&').replace(/%20/g, '+');

    // We define what will happen if the data are successfully sent
    XHR.addEventListener('load', function (event) {
        var response = JSON.parse(XHR.responseText);
        var token = response["access_token"];

        gapi.analytics.ready(function () {

            var view = "ga:176922835";
            gapi.analytics.auth.authorize({
                'serverAuth': {
                    'access_token': token
                }
            });

            new gapi.analytics.googleCharts.DataChart({
                query: {
                    'ids': view,
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday',
                    'metrics': 'ga:sessions',
                    'dimensions': 'ga:userType',
                    'sort': '-ga:sessions'
                },
                chart: {
                    'container': 'chartNew',
                    'type': 'PIE',
                    'options': {
                        'width': '100%'
                    }
                }
            }).execute();

            new gapi.analytics.googleCharts.DataChart({
                query: {
                    'ids': view,
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday',
                    'metrics': 'ga:sessions',
                    'dimensions': 'ga:sourceMedium',
                    'sort': '-ga:sessions',
                    'max-results': 10
                },
                chart: {
                    'container': 'chartSource',
                    'type': 'BAR',
                    'options': {
                        'width': '100%'
                    }
                }
            }).execute();

            new gapi.analytics.googleCharts.DataChart({
                query: {
                    'ids': view,
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday',
                    'metrics': 'ga:sessions',
                    'dimensions': 'ga:country',
                    'sort': '-ga:sessions',
                    'max-results': 100
                },
                chart: {
                    'container': 'chartGeo',
                    'type': 'GEO',
                    'options': {
                        'width': '100%'
                    }
                }
            }).execute();

            new gapi.analytics.googleCharts.DataChart({
                query: {
                    'ids': view,
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday',
                    'metrics': 'ga:sessions,ga:users',
                    'dimensions': 'ga:date'
                },
                chart: {
                    'container': 'chartVisit',
                    'type': 'LINE',
                    'options': {
                        'width': '100%'
                    }
                }
            }).execute();

            new gapi.analytics.googleCharts.DataChart({
                query: {
                    'ids': view,
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday',
                    'metrics': 'ga:pageviews',
                    'dimensions': 'ga:pagePathLevel1',
                    'sort': '-ga:pageviews',
                    'max-results': 10
                },
                chart: {
                    'container': 'chartContent',
                    'type': 'PIE',
                    'options': {
                        'width': '100%',
                    }
                }
            }).execute();

        });
    });

    // We define what will happen in case of error
    XHR.addEventListener('error', function (event) {
        console.log('Oops! Something went wrong.');
    });

    XHR.open('POST', 'https://www.googleapis.com/oauth2/v3/token');
    XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    XHR.send(urlEncodedData);
</script>
