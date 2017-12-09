<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\RestModel\Resources;

class ResourcesCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$list = [
    		// Regular - Emojis
    		['emoji','regular','1-um-zen.png',1,0,0,0],
    		['emoji','regular','1-um-sad.png',2,0,0,0],
    		['emoji','regular','1-um-loading.png',3,0,0,0],
    		['emoji','regular','1-um-joy.png',4,0,0,0],
    		['emoji','regular','1-um-high-sad.png',5,0,0,0],
    		['emoji','regular','1-um-high-joy.png',6,0,0,0],
    		['emoji','regular','1-um-excitement.png',7,0,0,0],
    		['emoji','regular','1-um-confusion.png',8,0,0,0],
    		['emoji','regular','1-um-clam.png',9,0,0,0],
    		['emoji','regular','1-um-aroused.png',10,0,0,0],
    		// Regular - Stickers
    		['sticker','regular','basic-reaction-verysad.png',1,0,0,0],
    		['sticker','regular','basic-reaction-tired.png',2,0,0,0],
    		['sticker','regular','basic-reaction-sleepy.png',3,0,0,0],
    		['sticker','regular','basic-reaction-shocked.png',4,0,0,0],
    		['sticker','regular','basic-reaction-relaxed.png',5,0,0,0],
    		['sticker','regular','basic-reaction-rage.png',6,0,0,0],
    		['sticker','regular','basic-reaction-okflirt.png',7,0,0,0],
    		['sticker','regular','basic-reaction-nervous.png',8,0,0,0],
    		['sticker','regular','basic-reaction-mad.png',9,0,0,0],
    		['sticker','regular','basic-reaction-irritated.png',10,0,0,0],
    		['sticker','regular','basic-reaction-furious.png',11,0,0,0],
    		['sticker','regular','basic-reaction-excited.png',12,0,0,0],
    		['sticker','regular','basic-reaction-depressed.png',13,0,0,0],
    		['sticker','regular','basic-reaction-crying.png',14,0,0,0],
    		['sticker','regular','basic-reaction-confortable.png',15,0,0,0],
    		['sticker','regular','basic-reaction-brokenhearted.png',16,0,0,0],
    		['sticker','regular','basic-reaction-anxious.png',17,0,0,0],
    		['sticker','regular','basic-reaction-adore.png',18,0,0,0],
    		['sticker','regular','basic-reaction-about-to-cry.png',19,0,0,0],
    		// Pancake - Emojis
    		['emoji','pancake','2-um-zen.png',1,0,0,0],
    		['emoji','pancake','2-um-sad.png',2,0,0,0],
    		['emoji','pancake','2-um-loading.png',3,0,0,0],
    		['emoji','pancake','2-um-joy.png',4,0,0,0],
    		['emoji','pancake','2-um-high-sad.png',5,0,0,0],
    		['emoji','pancake','2-um-high-joy.png',6,0,0,0],
    		['emoji','pancake','2-um-excitement.png',7,0,0,0],
    		['emoji','pancake','2-um-confusion.png',8,0,0,0],
    		['emoji','pancake','2-um-clam.png',9,0,0,0],
    		['emoji','pancake','2-um-aroused.png',10,0,0,0],
    		// Pancake - Stickers
			['sticker','pancake','pancake-angry.png ',1,0,0,0],
			['sticker','pancake','pancake-begging.png ',2,0,0,0],
			['sticker','pancake','pancake-calm.png ',3,0,0,0],
			['sticker','pancake','pancake-daydreaming.png ',4,0,0,0],
			['sticker','pancake','pancake-feelingblessed.png ',5,0,0,0],
			['sticker','pancake','pancake-furious.png ',6,0,0,0],
			['sticker','pancake','pancake-hello.png ',7,0,0,0],
			['sticker','pancake','pancake-hug.png ',8,0,0,0],
			['sticker','pancake','pancake-impatient.png ',9,0,0,0],
			['sticker','pancake','pancake-inlove.png ',10,0,0,0],
			['sticker','pancake','pancake-irritated.png ',11,0,0,0],
			['sticker','pancake','pancake-mad.png ',12,0,0,0],
			['sticker','pancake','pancake-melancholic.png ',13,0,0,0],
			['sticker','pancake','pancake-pleading.png ',14,0,0,0],
			['sticker','pancake','pancake-romantic.png',15,0,0,0],
			['sticker','pancake','pancake-shocked.png ',16,0,0,0],
			['sticker','pancake','pancake-speechless.png ',17,0,0,0],
			['sticker','pancake','pancake-terrified.png ',18,0,0,0],
			['sticker','pancake','pancake-thankful.png ',19,0,0,0],
			['sticker','pancake','pancake-uncontented.png ',20,0,0,0],
			['sticker','pancake','pancake-upset.png',21,0,0,0],
    		// Gummybear - Emojis
    		['emoji','gummybear','4-um-zen.png',1,0,0,0],
    		['emoji','gummybear','4-um-sad.png',2,0,0,0],
    		['emoji','gummybear','4-um-loading.png',3,0,0,0],
    		['emoji','gummybear','4-um-joy.png',4,0,0,0],
    		['emoji','gummybear','4-um-high-sad.png',5,0,0,0],
    		['emoji','gummybear','4-um-high-joy.png',6,0,0,0],
    		['emoji','gummybear','4-um-excitement.png',7,0,0,0],
    		['emoji','gummybear','4-um-confusion.png',8,0,0,0],
    		['emoji','gummybear','4-um-clam.png',9,0,0,0],
    		['emoji','gummybear','4-um-aroused.png',10,0,0,0],
    		// Gummybear - Stickers
			['sticker','gummybear','gummybear-afraid.png ',1,0,0,0],
			['sticker','gummybear','gummybear-angry.png ',2,0,0,0],
			['sticker','gummybear','gummybear-bored.png ',3,0,0,0],
			['sticker','gummybear','gummybear-bye.png ',4,0,0,0],
			['sticker','gummybear','gummybear-cold.png ',5,0,0,0],
			['sticker','gummybear','gummybear-embarrassed.png ',6,0,0,0],
			['sticker','gummybear','gummybear-fear.png ',7,0,0,0],
			['sticker','gummybear','gummybear-full.png ',8,0,0,0],
			['sticker','gummybear','gummybear-funny.png ',9,0,0,0],
			['sticker','gummybear','gummybear-gotmyeyesonyou.png ',10,0,0,0],
			['sticker','gummybear','gummybear-ididit.png ',11,0,0,0],
			['sticker','gummybear','gummybear-listening.png ',12,0,0,0],
			['sticker','gummybear','gummybear-loveatflrstsight.png ',13,0,0,0],
			['sticker','gummybear','gummybear-otl-fail.png ',14,0,0,0],
			['sticker','gummybear','gummybear-planningsomething.png',15,0,0,0],
			['sticker','gummybear','gummybear-reading.png ',16,0,0,0],
			['sticker','gummybear','gummybear-snigger.png ',17,0,0,0],
			['sticker','gummybear','gummybear-wander.png ',18,0,0,0],
			['sticker','gummybear','gummybear-wonder.png ',19,0,0,0],
			// Hotdog - Emojis
    		['emoji','hotdog','5-um-zen.png',1,0,0,0],
    		['emoji','hotdog','5-um-sad.png',2,0,0,0],
    		['emoji','hotdog','5-um-loading.png',3,0,0,0],
    		['emoji','hotdog','5-um-joy.png',4,0,0,0],
    		['emoji','hotdog','5-um-high-sad.png',5,0,0,0],
    		['emoji','hotdog','5-um-high-joy.png',6,0,0,0],
    		['emoji','hotdog','5-um-excitement.png',7,0,0,0],
    		['emoji','hotdog','5-um-confusion.png',8,0,0,0],
    		['emoji','hotdog','5-um-clam.png',9,0,0,0],
    		['emoji','hotdog','5-um-aroused.png',10,0,0,0],
    		// Hotdog - Stickers
			['sticker','hotdog','hotdog-angry.png ',1,0,0,0],
			['sticker','hotdog','hotdog-awkwardlaugh.png ',2,0,0,0],
			['sticker','hotdog','hotdog-bored.png ',3,0,0,0],
			['sticker','hotdog','hotdog-crazy.png ',4,0,0,0],
			['sticker','hotdog','hotdog-disgusted.png ',5,0,0,0],
			['sticker','hotdog','hotdog-donotknow.png ',6,0,0,0],
			['sticker','hotdog','hotdog-fighting.png ',7,0,0,0],
			['sticker','hotdog','hotdog-flips-table.png ',8,0,0,0],
			['sticker','hotdog','hotdog-fun.png ',9,0,0,0],
			['sticker','hotdog','hotdog-furious.png ',10,0,0,0],
			['sticker','hotdog','hotdog-lnlove.png ',11,0,0,0],
			['sticker','hotdog','hotdog-keepquiet.png ',12,0,0,0],
			['sticker','hotdog','hotdog-kiss.png ',13,0,0,0],
			['sticker','hotdog','hotdog-no.png ',14,0,0,0],
			['sticker','hotdog','hotdog-notpleased.png',15,0,0,0],
			['sticker','hotdog','hotdog-ok.png ',16,0,0,0],
			['sticker','hotdog','hotdog-overheard.png ',17,0,0,0],
			['sticker','hotdog','hotdog-please.png ',18,0,0,0],
			['sticker','hotdog','hotdog-spying.png ',19,0,0,0],
			['sticker','hotdog','hotdog-thinking.png ',20,0,0,0],
			['sticker','hotdog','hotdog-tired.png',21,0,0,0],

    	];

    	foreach ($list as $key => $value) {

    		$data[] = [
    			'type'       => $value[0],
				'set_name'   => $value[1],
				'filename'   => $value[2],
				'order'      => $value[3],
				'paid'       => $value[4],
				'status'     => $value[5],
				'deleted'    => $value[6],
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
    		];

    	}

    	Resources::insert($data);

    	echo 'Resources Collection Seeder Success!';

    }
}
