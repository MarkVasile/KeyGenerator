<?php

// from http://php.net/manual/en/function.microtime.php
function mini_bench_to($arg_t, $arg_ra=false)
  {
    $tttime=round((end($arg_t)-$arg_t['start'])*1000,4); // time since the beginning of benchmark log in ms
    if ($arg_ra) $ar_aff['total_time']=$tttime;
    else $aff="total time : ".$tttime." ms\n";
    $prv_cle='start';
    $prv_val=$arg_t['start'];

	// compute % for each milestone
    foreach ($arg_t as $cle=>$val)
    {
        if($cle!='start')
        {
            $prcnt_t=round(((round(($val-$prv_val)*1000,4)/$tttime)*100),1);
            if ($arg_ra) $ar_aff[$prv_cle.' -> '.$cle]=$prcnt_t;
            $aff .= "@ " . round(($val - $arg_t['start']),4) . " ms :: " . $prv_cle.' -> '.$cle.' : '.$prcnt_t." %\n";
            $prv_val=$val;
            $prv_cle=$cle;
        }
    }
    if ($arg_ra) return $ar_aff;
    return $aff;
  }

function logbm( $milestone ) {
	global $logger, $time_benchmark;
	if ( $milestone === true ) {
		// finalize and write log
		$debug_file = fopen("logs/benchmark.log", "a+");
		fwrite( $debug_file, "\n\nNEW BENCHMARK:\n" . mini_bench_to($time_benchmark) );
		fclose( $debug_file );
		unset($time_benchmark);
	}
	if (!isset($time_benchmark)) $time_benchmark['start'] = microtime(true);
	else $time_benchmark[$milestone] = microtime(true);
}

logbm('start');
for($i=0; $i<10000; $i++) {
    // this method failes on 32bit machines; Only works for max 5 chars on 32 bit machines
    $ret = base_convert(mt_rand(0x1D39D3E06400000, mt_getrandmax()), 10, 36);
}
logbm('base_convert');

// echo array to screen so i don't have to type
// $ret =  preg_split('//','qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM1234567890', -1);
// foreach ($ret as $v) echo "'$v',";

for($i=0; $i<10000; $i++) {
    $ret = array_rand(array('q','w','e','r','t','y','u','i','o','p','l','k','j','h','g','f','d','s','a','z','x','c','v','b','n','m','Q','W','E','R','T','Y','U','I','O','P','L','K','J','H','G','F','D','S','A','Z','X','C','V','B','N','M','1','2','3','4','5','6','7','8','9','0'), 12);
}
logbm('array_rand');
logbm(true);

?>
