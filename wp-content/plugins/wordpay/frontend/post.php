<?php 
//add_action( 'loop_start', 'your_function' );
add_filter('the_content', 'wordpay_frontend_post');
function wordpay_frontend_post() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'wordpay_authenticat';
  $mylink = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = 1", ARRAY_A );
  $production=$mylink['production'];
  $coins=$mylink['selected'];
  $cpd_id=$mylink['cpd_id'];
  global $post;
  if ( is_singular($post) ) 
  {
    wp_enqueue_script( "variable", plugin_dir_url( __FILE__ ) . '/bootstrap/js/variable.js', 'jQuery','1.0.0', true );
    wp_enqueue_style( 'custom1',plugins_url( '/bootstrap/css/custom1.css', __FILE__ ) );
    wp_enqueue_style( 'styles',plugins_url( '/bootstrap/signin-signup/css/styles.min.css', __FILE__ ) );
    wp_enqueue_script( 'jquery-min-js',plugins_url( '/bootstrap/signin-signup/js/jquery.min.js', __FILE__ ));
    wp_enqueue_script( 'bundle', plugins_url( '/bootstrap/signin-signup/js/bootstrap.bundle.js', __FILE__ ));
    wp_enqueue_script( 'custom', plugins_url( '/bootstrap/signin-signup/js/custom.js', 
      __FILE__ ));
    wp_enqueue_script( "signup-signin", plugin_dir_url( __FILE__ ) . '/bootstrap/js/signup-signin.js', 'jQuery','1.0.0', true );
    wp_localize_script( 'signup-signin', 'signin_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_localize_script( 'signup-signin', 'login_signin_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_localize_script( 'signup-signin', 'getcoin_signin_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_localize_script( 'signup-signin', 'articles_signin_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_localize_script( 'signup-signin', 'post_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_script( "signup", plugin_dir_url( __FILE__ ) . '/bootstrap/js/signup.js', 'jQuery','1.0.0', true );
    wp_localize_script( 'signup', 'signup_signin_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    $postid = get_the_ID();
    $wordpayonoff=get_post_meta( $postid, 'wordpayonoff', true );
    $wordpay_words=get_post_meta( $postid, 'wordpay_words', true );
    $fixedprice=get_post_meta( $postid, 'fixedprice', true );
    $minprice=get_post_meta( $postid, 'minprice', true );
    $maxprice=get_post_meta( $postid, 'maxprice', true );
    $priceid=get_post_meta( $postid, 'priceid', true );
    $title=get_the_title( $postid );
    $post_url=get_permalink( $postid );
    $publish_date=get_the_date( 'Y-m-d' ).' '.get_the_time( 'H:i:s' );
    $serverDetail = $_SERVER['SERVER_NAME'];
    $server_details=json_encode($serverDetail);
    /*user test mode code*/
    if ($production=='0') 
    {
        if (is_user_logged_in()) 
        {
             // user is an admin
               if($wordpayonoff=='1')
               {

                    if($wordpay_words)
                    {
                    $excerpt1="<div class='contentreads' id='wordpay_cId'>".wp_trim_words( get_the_content(), $wordpay_words,'
                    ...<br><div class="continuercss"><a  href="javascript:void(0)" id="Bst"  class="btn btn-primary"><br>CONTINUE<br>READING</a></div>' )."</div>";
                    echo $excerpt1;

                    }
                    else
                    {
                    
                    echo $excerpt1="<div id='wordpay_cId' class='contentreads'>".wp_trim_words( get_the_content(), 30,'...<br><div class="continuercss"><a  href="javascript:void(0)" id="Bst"  class="btn btn-primary"><br>CONTINUE<br>READING</a></div>' )."</div>";
                    }
                }
                else
                {
                   echo do_shortcode(get_post_field('post_content', $postid));
                ?>
    <style type="text/css">
        .div2 {
            display: none!important;
        }
        
        .login {
            display: none!important;
        }
    </style>
    <?php   
                }
        }
        else
        {
         echo do_shortcode(get_post_field('post_content', $postid));?>
        <style type="text/css">
            .div2 {
                display: none!important;
            }
            
            .login {
                display: none!important;
            }
        </style>
        <?php 
        }
    } 
    elseif ($production=='1')
    {
        if($wordpayonoff=='1')
        {
              if($wordpay_words)
              {
              
              $excerpt1="<div class='contentreads' id='wordpay_cId'>".wp_trim_words( get_the_content(), $wordpay_words,'
              ...<br><div class="continuercss"><a  href="javascript:void(0)" id="Bst"  class="btn btn-primary"><br>CONTINUE<br>READING</a></div>' )."</div>";
              echo $excerpt1;

              }
              else
              {
              echo $excerpt1="<div class='contentreads' id='wordpay_cId'>".wp_trim_words( get_the_content(), 30,'...<br><div class="continuercss"><a  href="javascript:void(0)" id="Bst"  class="btn btn-primary"><br>CONTINUE<br>READING</a></div>' )."</div>";

              }
        }
        else
        {
          echo do_shortcode(get_post_field('post_content', $postid));
        ?>
            <style type="text/css">
                .div2 {
                    display: none!important;
                }
                
                .login {
                    display: none!important;
                }
            </style>
            <?php   
        }

    }
    else { ?>
                <style type="text/css">
                    .div2 {
                        display: none!important;
                    }
                    
                    .login {
                        display: none!important;
                    }
                </style>
                <?php  
      echo do_shortcode(get_post_field('post_content', $postid));
    } 

     ?>
                    <!-- article read close -->
                    <!-- new design button readmore -->
    <div id="readmore" style="display: none;">
    <!-- <h1 id="resulted" style="text-align: center;"></h1> -->
    <div class="card">
    <?php 
        $query = new WP_Query(array(
         'p'         => $priceid,
        'post_type' => 'price-range',
        'post_status' => 'publish'
        ));
        while ($query->have_posts()) {
        $query->the_post();
        $postid1 = get_the_ID();
        $article_type=get_the_title( $postid1 );
        } wp_reset_postdata();
    ?>
                                <input class="" type="hidden" value="<?php echo site_url(); ?>" id="domain" />
                                <input class="" type="hidden" value="<?php echo $minprice; ?>" id="minprice12" />
                                <input class="" type="hidden" value="<?php echo $maxprice; ?>" id="maxprice12" />
                                <input class="" type="hidden" value="<?php echo $fixedprice ?>" id="fixedprice12" />
                                <input class="" type="hidden" value="<?php echo $postid; ?>" id="postid12" />
                                <input class="" type="hidden" value="<?php echo $title; ?>" id="posttitle12" />
                                <input class="" type="hidden" value="<?php echo $post_url; ?>" id="post_url12" />
                                <input class="" type="hidden" value="<?php echo $article_type; ?>" id="article_type123" />
                                <input class="" type="hidden" value="<?php  echo $cpd_id; ?>" id="cpd_id12" />
                                <input class="" type="hidden" value="<?php  echo $publish_date; ?>" id="publish_date" />
                                <input class="" type="hidden" value="<?php  echo $server_details; ?>" id="server_details" />
                                <input class="" type="hidden" value="<?php  echo $production; ?>" id="wpmodes123" />
                            <div class="coin">
                                <div class="coinBt">
                                    <?php echo $fixedprice ?> coins
                                </div>
                            </div>

                            <div class="coin">
                                <div class="coinImg">
                                    
                                    <span class="text_1"><wordpay id='blance_coin'></wordpay></span>
                                    <div class="coinBal">Coin Balace</div>
                                </div>
                            </div>

                            <div class="coin coinImages">
                                <a href="javascript:void(0)" class="btn-gradient" onClick="validatCoin(1)">
                                <img src="<?PHP echo plugin_dir_url( dirname( __FILE__ ) ) . 'frontend/bootstrap/signin-signup/imgs/4.png'?>">
                                </a>
                            </div>
                            
                        </div>
                        <center>
                                <div class="sign-up mb-4 mt-4 text-uppercase">
                                ARE YOU NOT <?php echo $_COOKIE["firstname"]; ?>? <a href="javascript:void(0)" onClick="logoutcokes()">SIGN OUT</a><br>
                                <span> POWERED BY WORDPAY </span>
                            </div>
                        </center>
                     </div>   
                    <!-- new design button readmore close -->
                    <!-- new design button byecoins -->
                    <div id="byecoins" style="display: none;">
                    <!-- <h1 style="text-align: center;" id="resulted"></h1> -->
                   <div class="card">
                        <div class="coin">
                            <div class="coinBt">
                            <?php echo $fixedprice ?> coins
                            </div>
                        </div>
                        <div class="coin">
                            <div class="coinImg">
                                <span class="text_1"><wordpay id='buy_coin'></wordpay></span>
                                    <div class="coinBal">Coin Balace</div>
                            </div>
                        </div>

                        <div class="coin">
                            <a href="#" target="_blank" class="btn-gradient">
                            <div class="coinBtNew">
                            Buy Coins
                        </div>
                            </a>
                        </div>
                                            
                        </div>
                        <center>
                                <div class="sign-up mb-4 mt-4 text-uppercase">
                                ARE YOU NOT <?php echo $_COOKIE["firstname"]; ?>? <a href="javascript:void(0)" onClick="logoutcokes()">SIGN OUT</a><br>
                                <span> POWERED BY WORDPAY </span>
                            </div>
                        </center>
                    </div>
                    <!-- close design -->
                    <!-- Login Section Begins byecoins -->
                    <section class="login" id="login" style="display: none;">
                        <div class="login-form">
                            <div class="white-box">
                                <form class="user-login" action="" id="post-form1">
                                    <h2 class="text-center">
              SIGN IN
              <span class="coins"><?php echo $fixedprice ?> <?php echo $coins; ?></span>
            </h2>
                                    <!-- Add  "error" class on validation
            <div class="username error">
            -->
                                    <div class="username">
                                        <h1 id="results"></h1>
                                        <label for="email">Email</label>
                                        <input class="" type="text" id="email1" placeholder="Type your email here..." />
                                        <?php 
                                          $query = new WP_Query(array(
                                             'p'         => $priceid,
                                           'post_type' => 'price-range',
                                            'post_status' => 'publish'
                                            ));
                                            while ($query->have_posts()) {
                                            $query->the_post();
                                            $postid1 = get_the_ID();
                                            $article_type=get_the_title( $postid1 );
                                          }wp_reset_postdata(); ?>
                                            <input class="" type="hidden" value="<?php echo site_url(); ?>" id="domain" />
                                            <input class="" type="hidden" value="<?php echo $minprice; ?>" id="minprice" />
                                            <input class="" type="hidden" value="<?php echo $maxprice; ?>" id="maxprice" />
                                            <input class="" type="hidden" value="<?php echo $fixedprice ?>" id="fixedprice" />
                                            <input class="" type="hidden" value="<?php echo $postid; ?>" id="postid" />
                                            <input class="" type="hidden" value="<?php echo $title; ?>" id="posttitle" />
                                            <input class="" type="hidden" value="<?php echo $post_url; ?>" id="post_url1" />
                                            <input class="" type="hidden" value="<?php echo $article_type; ?>" id="article_type1" />
                                            <input class="" type="hidden" value="<?php $user=" user "; echo $user; ?>" id="user_type" />
                                            <input class="" type="hidden" value="<?php  echo $cpd_id; ?>" id="cpd_id" />
                                            <input class="" type="hidden" value="<?php  echo $publish_date; ?>" id="publish_date1" />
                                            <input class="" type="hidden" value="<?php  echo $production; ?>" id="wpmodes" />
                                    </div>
                                    <div class="password">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" placeholder="Type your password here..." />
                                    </div>
                                    <div class="clearfix mt-2"></div>
                                    <button type="submit" class="btn-gradient" onClick="showlogin()">
                                        SIGN IN
                                        <img src="<?PHP echo plugin_dir_url( dirname( __FILE__ ) ) . 'frontend/bootstrap/signin-signup/images/arrow_forward.png'?>" alt="" />
                                    </button>
                                </form>
                            </div>
                            <div class="sign-up mb-4 mt-4 text-uppercase">
                                Don’t have an account? <a href="javascript:void(0)" onClick="myFunction1()">Sign Up </a>
                                <span> POWERED BY WORDPAY </span>
                            </div>
                        </div>
                    </section>
                    <!-- Login Section Close  -->
                    <!-- Signup Section Begins -->
                    <section class="login" id="signup" style="display: none;">
                        <div class="login-form">
                            <h1 id="result1"></h1>
                            <div class="white-box">
                                <form class="user-login" action="" name="signup" id="signup">
                                    <h2 class="text-center">
              SIGN UP
              <span class="coins"><?php echo $fixedprice ?> <?php echo $coins; ?></span>
            </h2>
                                    <!-- Add  "error" class on validation
            <div class="username error">
            -->
                                    <div class="username">
                                        <label for="fullname">First Name</label>
                                        <input class="" type="text" id="first_name" placeholder="Enter First Name" />
                                    </div>
                                    <div class="username">
                                        <label for="fullname">Last Name</label>
                                        <input class="" type="text" id="last_name" placeholder="Enter Last Name " />
                                    </div>
                                    <div class="email">
                                        <label for="email">Email</label>
                                        <input class="" type="text" id="email2" placeholder="Enter Email " />
                                        <input class="" type="hidden" value="<?php echo site_url(); ?>" id="website" />
                                        <input class="" type="hidden" value="<?php $user=" user "; echo $user; ?>" id="user_type1" />
                                    </div>
                                    <div class="password">
                                        <label for="password">Password</label>
                                        <input type="password" id="password1" placeholder="Password" />
                                    </div>

                                    <div class="clearfix mt-2"></div>

                                    <label class="signup-checkbox">
                                        <input type="checkbox" name="check" checked="" />
                                        <h3 class="label-text">Vil du bruge Wordpay?</h3>
                                        <p>
                                            Ja, jeg vil gerne bruge Wordpay til betaling for artikler og podcasts. Wordpay annonymiserer mine data og benytter dem, så jeg nemt kan logge ind og betale på alle medier med Wordpay betaling. Mine informationer, data og betalingsoplysninger beskyttes i henhold til gældende lovgivning og PCI-sikkerhedsstandarden.
                                        </p>
                                    </label>

                                    <button type="submit" class="btn-gradient">
                                        SIGN UP
                                        <img src="<?PHP echo plugin_dir_url( dirname( __FILE__ ) ) . 'frontend/bootstrap/signin-signup/images/arrow_forward.png'?>" alt="" />
                                    </button>

                                    <div class="sign-up find-out ">
                                        <a href="javascript:void(0)"> find out about wordpay</a>
                                    </div>
                                </form>
                            </div>
                            <div class="sign-up mb-4 mt-4 text-uppercase">
                                already have an account? <a href="javascript:void(0)" onClick="myFunction2()">Sign IN </a>
                                <span> POWERED BY WORDPAY </span>
                            </div>
                        </div>
                    </section>
                    <!-- Signup Section close -->
                    <script type="text/javascript">
                        function myFunction1() {
                            $("#login").hide();
                            $("#signup").show();
                        };

                        function myFunction2() {
                            $("#login").show();
                            $("#signup").hide();
                        };
                    </script>
                    <?php
  }
}