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

        $setName = [
            'alien',
            'bean',
            'bunny',
            'chick',
            'cloud',
            'coupleyoga',
            'deer',
            'doughnut',
            'gummybear',
            'hotdog',
            'marchmallow',
            'pancake',
            'regular',
            'whacky',
            'yogabear',
            'yogagirl',
        ];

        $emotion = [
            'zen',
            'struggle',
            'loading',
            'joy',
            'high-sad',
            'high-joy',
            'excitement',
            'confusion',
            'calm',
            'arousal',
            'anxious',
        ];

        foreach ($setName as $key1 => $set) {
            
            foreach ($emotion as $key2 => $emo) {
                
                $emoji[] = [ 'emoji', $emo, $set, $emo.'.png', $key2+1, 0, 1, 0 ];

            }

        }

    	$sticker = [

            ['sticker',null,'regular','twitterpated.png',1,0,1,0],
    		['sticker',null,'regular','tired.png',2,0,1,0],
    		['sticker',null,'regular','shocked.png',3,0,1,0],
            ['sticker',null,'regular','pity.png',4,0,1,0],
    		['sticker',null,'regular','okflirt.png',5,0,1,0],
            ['sticker',null,'regular','nervous.png',6,0,1,0],
            ['sticker',null,'regular','mad.png',7,0,1,0],
            ['sticker',null,'regular','irritated.png',8,0,1,0],
    		['sticker',null,'regular','furious.png',9,0,1,0],
    		['sticker',null,'regular','confortable.png',10,0,1,0],
            ['sticker',null,'regular','brokenhearted.png',11,0,1,0],
    		['sticker',null,'regular','bored.png',12,0,1,0],
    		['sticker',null,'regular','anxious.png',13,0,1,0],
    		['sticker',null,'regular','adore.png',14,0,1,0],
    		['sticker',null,'regular','about-to-cry.png',15,0,1,0],

			['sticker',null,'pancake','angry.png ',1,0,1,0],
			['sticker',null,'pancake','begging.png ',2,0,1,0],
			['sticker',null,'pancake','blesse.png ',3,0,1,0],
			['sticker',null,'pancake','daydreaming.png ',4,0,1,0],
			['sticker',null,'pancake','feelingblessed.png ',5,0,1,0],
			['sticker',null,'pancake','furious.png ',6,0,1,0],
			['sticker',null,'pancake','hello.png ',7,0,1,0],
			['sticker',null,'pancake','hug.png ',8,0,1,0],
			['sticker',null,'pancake','impatient.png ',9,0,1,0],
			['sticker',null,'pancake','inlove.png ',10,0,1,0],
			['sticker',null,'pancake','irritated.png ',11,0,1,0],
			['sticker',null,'pancake','mad.png ',12,0,1,0],
			['sticker',null,'pancake','melancholic.png ',13,0,1,0],
			['sticker',null,'pancake','pleading.png ',14,0,1,0],
			['sticker',null,'pancake','romantic.png',15,0,1,0],
			['sticker',null,'pancake','shocked.png ',16,0,1,0],
			['sticker',null,'pancake','speechless.png ',17,0,1,0],
			['sticker',null,'pancake','terrified.png ',18,0,1,0],
			['sticker',null,'pancake','thankful.png ',19,0,1,0],
			['sticker',null,'pancake','uncontented.png ',20,0,1,0],
			['sticker',null,'pancake','upset.png',21,0,1,0],

			['sticker',null,'gummybear','gummybear-afraid.png ',1,0,1,0],
			['sticker',null,'gummybear','gummybear-angry.png ',2,0,1,0],
			['sticker',null,'gummybear','gummybear-bored.png ',3,0,1,0],
			['sticker',null,'gummybear','gummybear-bye.png ',4,0,1,0],
			['sticker',null,'gummybear','gummybear-cold.png ',5,0,1,0],
			['sticker',null,'gummybear','gummybear-embarrassed.png ',6,0,1,0],
			['sticker',null,'gummybear','gummybear-fear.png ',7,0,1,0],
			['sticker',null,'gummybear','gummybear-full.png ',8,0,1,0],
			['sticker',null,'gummybear','gummybear-funny.png ',9,0,1,0],
			['sticker',null,'gummybear','gummybear-gotmyeyesonyou.png ',10,0,1,0],
			['sticker',null,'gummybear','gummybear-ididit.png ',11,0,1,0],
			['sticker',null,'gummybear','gummybear-listening.png ',12,0,1,0],
			['sticker',null,'gummybear','gummybear-loveatflrstsight.png ',13,0,1,0],
			['sticker',null,'gummybear','gummybear-otl-fail.png ',14,0,1,0],
			['sticker',null,'gummybear','gummybear-planningsomething.png',15,0,1,0],
			['sticker',null,'gummybear','gummybear-reading.png ',16,0,1,0],
			['sticker',null,'gummybear','gummybear-snigger.png ',17,0,1,0],
			['sticker',null,'gummybear','gummybear-wander.png ',18,0,1,0],
			['sticker',null,'gummybear','gummybear-wonder.png ',19,0,1,0],

			['sticker',null,'hotdog','hotdog-angry.png ',1,0,1,0],
			['sticker',null,'hotdog','hotdog-awkwardlaugh.png ',2,0,1,0],
			['sticker',null,'hotdog','hotdog-bored.png ',3,0,1,0],
			['sticker',null,'hotdog','hotdog-crazy.png ',4,0,1,0],
			['sticker',null,'hotdog','hotdog-disgusted.png ',5,0,1,0],
			['sticker',null,'hotdog','hotdog-donotknow.png ',6,0,1,0],
			['sticker',null,'hotdog','hotdog-fighting.png ',7,0,1,0],
			['sticker',null,'hotdog','hotdog-flips-table.png ',8,0,1,0],
			['sticker',null,'hotdog','hotdog-fun.png ',9,0,1,0],
			['sticker',null,'hotdog','hotdog-furious.png ',10,0,1,0],
			['sticker',null,'hotdog','hotdog-lnlove.png ',11,0,1,0],
			['sticker',null,'hotdog','hotdog-keepquiet.png ',12,0,1,0],
			['sticker',null,'hotdog','hotdog-kiss.png ',13,0,1,0],
			['sticker',null,'hotdog','hotdog-no.png ',14,0,1,0],
			['sticker',null,'hotdog','hotdog-notpleased.png',15,0,1,0],
			['sticker',null,'hotdog','hotdog-ok.png ',16,0,1,0],
			['sticker',null,'hotdog','hotdog-overheard.png ',17,0,1,0],
			['sticker',null,'hotdog','hotdog-please.png ',18,0,1,0],
			['sticker',null,'hotdog','hotdog-spying.png ',19,0,1,0],
			['sticker',null,'hotdog','hotdog-thinking.png ',20,0,1,0],
			['sticker',null,'hotdog','hotdog-tired.png',21,0,1,0],

    	];

        $record = array_merge($emoji, $sticker);

        dd($record);

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
