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
            'anxious',
            'calm',
            'challenge',
            'confusion',
            'excitement',
            'happy',
            'hyped',
            'loading',
            'pleasant',
            'sad',
            'unpleasant',
            'zen',
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
    		['sticker',null,'regular','aghast.png',13,0,1,0],
    		['sticker',null,'regular','adore.png',14,0,1,0],
    		['sticker',null,'regular','about-to-cry.png',15,0,1,0],

			['sticker',null,'pancake','angry.png',1,0,1,0],
			['sticker',null,'pancake','begging.png',2,0,1,0],
			['sticker',null,'pancake','blessed.png',3,0,1,0],
			['sticker',null,'pancake','furious.png',4,0,1,0],
			['sticker',null,'pancake','hello.png',5,0,1,0],
			['sticker',null,'pancake','hug,png',6,0,1,0],
			['sticker',null,'pancake','impatient.png',7,0,1,0],
			['sticker',null,'pancake','in-love.png',8,0,1,0],
			['sticker',null,'pancake','irritated.png',9,0,1,0],
			['sticker',null,'pancake','mad.png',10,0,1,0],
			['sticker',null,'pancake','romantic.png',11,0,1,0],
			['sticker',null,'pancake','terrified.png',12,0,1,0],
			['sticker',null,'pancake','thankful.png',13,0,1,0],
			['sticker',null,'pancake','uncontented.png',14,0,1,0],
			['sticker',null,'pancake','upset.png',15,0,1,0],

			['sticker',null,'gummybear','afraid.png',1,0,1,0],
			['sticker',null,'gummybear','angry.png',2,0,1,0],
			['sticker',null,'gummybear','bye.png',3,0,1,0],
			['sticker',null,'gummybear','embarrassed.png',4,0,1,0],
			['sticker',null,'gummybear','fail.png',5,0,1,0],
			['sticker',null,'gummybear','fear.png',6,0,1,0],
			['sticker',null,'gummybear','full.png',7,0,1,0],
			['sticker',null,'gummybear','funny.png',8,0,1,0],
			['sticker',null,'gummybear','got-my-eyes-on-you.png ',9,0,1,0],
			['sticker',null,'gummybear','listening.png',10,0,1,0],
			['sticker',null,'gummybear','love-at-first-sight.png',11,0,1,0],
			['sticker',null,'gummybear','snigger.png',12,0,1,0],
			['sticker',null,'gummybear','wander.png',13,0,1,0],
			['sticker',null,'gummybear','wicked.png',14,0,1,0],
			['sticker',null,'gummybear','wonder.png',15,0,1,0],


			['sticker',null,'hotdog','angry.png',1,0,1,0],
			['sticker',null,'hotdog','awkward-laugh.png',2,0,1,0],
			['sticker',null,'hotdog','bored.png',3,0,1,0],
			['sticker',null,'hotdog','crazy.png',4,0,1,0],
			['sticker',null,'hotdog','dingfisted.png',5,0,1,0],
			['sticker',null,'hotdog','fighting.png',6,0,1,0],
			['sticker',null,'hotdog','flips-table.png',7,0,1,0],
			['sticker',null,'hotdog','keep-quiet.png',8,0,1,0],
			['sticker',null,'hotdog','kiss.png',9,0,1,0],
			['sticker',null,'hotdog','no.png',10,0,1,0],
			['sticker',null,'hotdog','not-pleased.png',11,0,1,0],
			['sticker',null,'hotdog','ok.png',12,0,1,0],
			['sticker',null,'hotdog','please.png',13,0,1,0],
			['sticker',null,'hotdog','spying.png',14,0,1,0],
			['sticker',null,'hotdog','tired.png',15,0,1,0],

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
