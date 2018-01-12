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
            'marshmallow',
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

            ['sticker',null,'cloud','you-suck.png',1,0,1,0],
            ['sticker',null,'cloud','wave.png',2,0,1,0],
            ['sticker',null,'cloud','sulky.png',3,0,1,0],
            ['sticker',null,'cloud','sleep.png',4,0,1,0],
            ['sticker',null,'cloud','satisfied.png',5,0,1,0],
            ['sticker',null,'cloud','panic.png',6,0,1,0],
            ['sticker',null,'cloud','mad.png',7,0,1,0],
            ['sticker',null,'cloud','love.png',8,0,1,0],
            ['sticker',null,'cloud','laugh.png',9,0,1,0],
            ['sticker',null,'cloud','glare.png',10,0,1,0],
            ['sticker',null,'cloud','freeze.png',11,0,1,0],
            ['sticker',null,'cloud','despise.png',12,0,1,0],
            ['sticker',null,'cloud','chuckle.png',13,0,1,0],
            ['sticker',null,'cloud','bored.png',14,0,1,0],
            ['sticker',null,'cloud','beg.png',15,0,1,0],

            ['sticker',null,'pancake','angry.png',1,1,1,0],
            ['sticker',null,'pancake','begging.png',2,1,1,0],
            ['sticker',null,'pancake','blessed.png',3,1,1,0],
            ['sticker',null,'pancake','furious.png',4,1,1,0],
            ['sticker',null,'pancake','hello.png',5,1,1,0],
            ['sticker',null,'pancake','hug,png',6,1,1,0],
            ['sticker',null,'pancake','impatient.png',7,1,1,0],
            ['sticker',null,'pancake','in-love.png',8,1,1,0],
            ['sticker',null,'pancake','irritated.png',9,1,1,0],
            ['sticker',null,'pancake','mad.png',10,1,1,0],
            ['sticker',null,'pancake','romantic.png',11,1,1,0],
            ['sticker',null,'pancake','terrified.png',12,1,1,0],
            ['sticker',null,'pancake','thankful.png',13,1,1,0],
            ['sticker',null,'pancake','uncontented.png',14,1,1,0],
            ['sticker',null,'pancake','upset.png',15,1,1,0],


			['sticker',null,'hotdog','angry.png',1,1,1,0],
			['sticker',null,'hotdog','awkward-laugh.png',2,1,1,0],
			['sticker',null,'hotdog','bored.png',3,1,1,0],
			['sticker',null,'hotdog','crazy.png',4,1,1,0],
			['sticker',null,'hotdog','dingfisted.png',5,1,1,0],
			['sticker',null,'hotdog','fighting.png',6,1,1,0],
			['sticker',null,'hotdog','flips-table.png',7,1,1,0],
			['sticker',null,'hotdog','keep-quiet.png',8,1,1,0],
			['sticker',null,'hotdog','kiss.png',9,1,1,0],
			['sticker',null,'hotdog','no.png',10,1,1,0],
			['sticker',null,'hotdog','not-pleased.png',11,1,1,0],
			['sticker',null,'hotdog','ok.png',12,1,1,0],
			['sticker',null,'hotdog','please.png',13,1,1,0],
			['sticker',null,'hotdog','spying.png',14,1,1,0],
			['sticker',null,'hotdog','tired.png',15,1,1,0],

            ['sticker',null,'yogagirl','sleepy.png',1,1,1,0],
            ['sticker',null,'yogagirl','sleep.png',2,1,1,0],
            ['sticker',null,'yogagirl','rush.png',3,1,1,0],
            ['sticker',null,'yogagirl','love.png',4,1,1,0],
            ['sticker',null,'yogagirl','lazy.png',5,1,1,0],
            ['sticker',null,'yogagirl','impatient.png',6,1,1,0],
            ['sticker',null,'yogagirl','hungry.png',7,1,1,0],
            ['sticker',null,'yogagirl','hands-up.png',8,1,1,0],
            ['sticker',null,'yogagirl','embarrassed.png',9,1,1,0],
            ['sticker',null,'yogagirl','depressed.png',10,1,1,0],
            ['sticker',null,'yogagirl','dance.png',11,1,1,0],
            ['sticker',null,'yogagirl','dance2.png',12,1,1,0],
            ['sticker',null,'yogagirl','congratulations.png',13,1,1,0],
            ['sticker',null,'yogagirl','bored.png',14,1,1,0],
            ['sticker',null,'yogagirl','angry.png',15,1,1,0],
            
            ['sticker',null,'yogabear','want.png',1,1,1,0],
            ['sticker',null,'yogabear','tired.png',2,1,1,0],
            ['sticker',null,'yogabear','think.png',3,1,1,0],
            ['sticker',null,'yogabear','swim.png',4,1,1,0],
            ['sticker',null,'yogabear','sweet.png',5,1,1,0],
            ['sticker',null,'yogabear','speechless.png',6,1,1,0],
            ['sticker',null,'yogabear','sleep.png',7,1,1,0],
            ['sticker',null,'yogabear','see.png',8,1,1,0],
            ['sticker',null,'yogabear','satisfy.png',9,1,1,0],
            ['sticker',null,'yogabear','relax.png',10,1,1,0],
            ['sticker',null,'yogabear','raise.png',11,1,1,0],
            ['sticker',null,'yogabear','mad.png',12,1,1,0],
            ['sticker',null,'yogabear','look.png',13,1,1,0],
            ['sticker',null,'yogabear','hold.png',14,1,1,0],
            ['sticker',null,'yogabear','eat.png',15,1,1,0],

            ['sticker',null,'whacky','yay.png',1,1,1,0],
            ['sticker',null,'whacky','upset.png',2,1,1,0],
            ['sticker',null,'whacky','Throw.png',3,1,1,0],
            ['sticker',null,'whacky','sweet.png',4,1,1,0],
            ['sticker',null,'whacky','shake.png',5,1,1,0],
            ['sticker',null,'whacky','pretend.png',6,1,1,0],
            ['sticker',null,'whacky','mad.png',7,1,1,0],
            ['sticker',null,'whacky','lazy.png',8,1,1,0],
            ['sticker',null,'whacky','hungry.png',9,1,1,0],
            ['sticker',null,'whacky','ecstatic.png',10,1,1,0],
            ['sticker',null,'whacky','confident.png',11,1,1,0],
            ['sticker',null,'whacky','comfortable.png',12,1,1,0],
            ['sticker',null,'whacky','cheerful.png',13,1,1,0],
            ['sticker',null,'whacky','blue.png',14,1,1,0],
            ['sticker',null,'whacky','angry.png',15,1,1,0],

            ['sticker',null,'marshmallow','unhappy.png',1,1,1,0],
            ['sticker',null,'marshmallow','twinkle.png',2,1,1,0],
            ['sticker',null,'marshmallow','sweet.png',3,1,1,0],
            ['sticker',null,'marshmallow','strong.png',4,1,1,0],
            ['sticker',null,'marshmallow','stare.png',5,1,1,0],
            ['sticker',null,'marshmallow','sneak.png',6,1,1,0],
            ['sticker',null,'marshmallow','smile.png',7,1,1,0],
            ['sticker',null,'marshmallow','plump.png',8,1,1,0],
            ['sticker',null,'marshmallow','melt.png',9,1,1,0],
            ['sticker',null,'marshmallow','mad.png',10,1,1,0],
            ['sticker',null,'marshmallow','hot.png',11,1,1,0],
            ['sticker',null,'marshmallow','greedy.png',12,1,1,0],
            ['sticker',null,'marshmallow','crowd.png',13,1,1,0],
            ['sticker',null,'marshmallow','comfortable.png',14,1,1,0],
            ['sticker',null,'marshmallow','angry.png',15,1,1,0],


            ['sticker',null,'doughnut','tired.png',1,1,1,0],
            ['sticker',null,'doughnut','stupefied.png',2,1,1,0],
            ['sticker',null,'doughnut','shock.png',3,1,1,0],
            ['sticker',null,'doughnut','remorse.png',4,1,1,0],
            ['sticker',null,'doughnut','regret.png',5,1,1,0],
            ['sticker',null,'doughnut','nervous.png',6,1,1,0],
            ['sticker',null,'doughnut','melancholic.png',7,1,1,0],
            ['sticker',null,'doughnut','leftout.png',8,1,1,0],
            ['sticker',null,'doughnut','imaginative.png',9,1,1,0],
            ['sticker',null,'doughnut','i-see.png',10,1,1,0],
            ['sticker',null,'doughnut','hot.png',11,1,1,0],
            ['sticker',null,'doughnut','fun.png',12,1,1,0],
            ['sticker',null,'doughnut','embarrassed.png',13,1,1,0],
            ['sticker',null,'doughnut','angry.png',14,1,1,0],
            ['sticker',null,'doughnut','amazement.png',15,1,1,0],


            ['sticker',null,'deer','sweet-love.png',1,1,1,0],
            ['sticker',null,'deer','sorry.png',2,1,1,0],
            ['sticker',null,'deer','sick.png',3,1,1,0],
            ['sticker',null,'deer','shy2.png',4,1,1,0],
            ['sticker',null,'deer','shy.png',5,1,1,0],
            ['sticker',null,'deer','scared.png',6,1,1,0],
            ['sticker',null,'deer','ok.png',7,1,1,0],
            ['sticker',null,'deer','no.png',8,1,1,0],
            ['sticker',null,'deer','love.png',9,1,1,0],
            ['sticker',null,'deer','impatient.png',10,1,1,0],
            ['sticker',null,'deer','hi.png ',11,1,1,0],
            ['sticker',null,'deer','happy.png',12,1,1,0],
            ['sticker',null,'deer','freeze.png',13,1,1,0],
            ['sticker',null,'deer','angry2.png',14,1,1,0],
            ['sticker',null,'deer','angry.png',15,1,1,0],


            ['sticker',null,'coupleyoga','sweet.png',1,1,1,0],
            ['sticker',null,'coupleyoga','punish1.png',2,1,1,0],
            ['sticker',null,'coupleyoga','punish2.png',3,1,1,0],
            ['sticker',null,'coupleyoga','please.png',4,1,1,0],
            ['sticker',null,'coupleyoga','ok.png',5,1,1,0],
            ['sticker',null,'coupleyoga','love-You2.png',6,1,1,0],
            ['sticker',null,'coupleyoga','love-You.png',7,1,1,0],
            ['sticker',null,'coupleyoga','kick.png',8,1,1,0],
            ['sticker',null,'coupleyoga','helpless.png',9,1,1,0],
            ['sticker',null,'coupleyoga','heavy.png',10,1,1,0],
            ['sticker',null,'coupleyoga','eye-contact.png',11,1,1,0],
            ['sticker',null,'coupleyoga','congratulations.png',12,1,1,0],
            ['sticker',null,'coupleyoga','circle.png',13,1,1,0],
            ['sticker',null,'coupleyoga','bye.png',14,1,1,0],
            ['sticker',null,'coupleyoga','angry.png',15,1,1,0],

            ['sticker',null,'chick','sweet.png',1,1,1,0],
            ['sticker',null,'chick','stack.png',2,1,1,0],
            ['sticker',null,'chick','speechless.png',3,1,1,0],
            ['sticker',null,'chick','sneak.png',4,1,1,0],
            ['sticker',null,'chick','sleep.png',5,1,1,0],
            ['sticker',null,'chick','sleeping.png',6,1,1,0],
            ['sticker',null,'chick','sick.png',7,1,1,0],
            ['sticker',null,'chick','satisfied.png',8,1,1,0],
            ['sticker',null,'chick','nervous.png',9,1,1,0],
            ['sticker',null,'chick','mad.png',10,1,1,0],
            ['sticker',null,'chick','hug.png',11,1,1,0],
            ['sticker',null,'chick','couple.png',12,1,1,0],
            ['sticker',null,'chick','comfort.png',13,1,1,0],
            ['sticker',null,'chick','caught-a-cold.png',14,1,1,0],
            ['sticker',null,'chick','angry.png',15,1,1,0],

            ['sticker',null,'bunny','think.png',1,1,1,0],
            ['sticker',null,'bunny','sweet.png',2,1,1,0],
            ['sticker',null,'bunny','speechless.png',3,1,1,0],
            ['sticker',null,'bunny','sleep.png',4,1,1,0],
            ['sticker',null,'bunny','mad.png',5,1,1,0],
            ['sticker',null,'bunny','impressed.png',6,1,1,0],
            ['sticker',null,'bunny','heart.png',7,1,1,0],
            ['sticker',null,'bunny','good.png',8,1,1,0],
            ['sticker',null,'bunny','face-please.png',9,1,1,0],
            ['sticker',null,'bunny','dispite.png',10,1,1,0],
            ['sticker',null,'bunny','cute.png',11,1,1,0],
            ['sticker',null,'bunny','confused.png',12,1,1,0],
            ['sticker',null,'bunny','chu.png',13,1,1,0],
            ['sticker',null,'bunny','byebye.png',14,1,1,0],
            ['sticker',null,'bunny','angry.png',15,1,1,0],

            ['sticker',null,'bean','touched.png',1,1,1,0],
            ['sticker',null,'bean','sleep.png',2,1,1,0],
            ['sticker',null,'bean','shy.png',3,1,1,0],
            ['sticker',null,'bean','shock.png',4,1,1,0],
            ['sticker',null,'bean','scared.png',5,1,1,0],
            ['sticker',null,'bean','mad.png',6,1,1,0],
            ['sticker',null,'bean','love You.png',7,1,1,0],
            ['sticker',null,'bean','lazy.png',8,1,1,0],
            ['sticker',null,'bean','laugh.png',9,1,1,0],
            ['sticker',null,'bean','good.png',10,1,1,0],
            ['sticker',null,'bean','comfort.png',11,1,1,0],
            ['sticker',null,'bean','clap.png',12,1,1,0],
            ['sticker',null,'bean','cheerful.png',13,1,1,0],
            ['sticker',null,'bean','bye.png',14,1,1,0],
            ['sticker',null,'bean','breakdown.png',15,1,1,0],

            ['sticker',null,'alien','transfer.png',1,1,1,0],
            ['sticker',null,'alien','shush.png',2,1,1,0],
            ['sticker',null,'alien','Reject.png',3,1,1,0],
            ['sticker',null,'alien','please.png',4,1,1,0],
            ['sticker',null,'alien','mad.png',5,1,1,0],
            ['sticker',null,'alien','hit.png',6,1,1,0],
            ['sticker',null,'alien','hi.png',7,1,1,0],
            ['sticker',null,'alien','hate.png',8,1,1,0],
            ['sticker',null,'alien','crazy.png',9,1,1,0],
            ['sticker',null,'alien','comfort.png',10,1,1,0],
            ['sticker',null,'alien','cheerful.png',11,1,1,0],
            ['sticker',null,'alien','bye.png',12,1,1,0],
            ['sticker',null,'alien','arrive.png',13,1,1,0],
            ['sticker',null,'alien','angry.png',14,1,1,0],
            ['sticker',null,'alien','agree.png',15,1,1,0],

    	];

        $record = array_merge($emoji, $sticker);

    	foreach ($record as $key => $value) {

    		$data[] = [
                'type'       => $value[0],
                'emotion'    => $value[1],
                'set_name'   => $value[2],
                'filename'   => $value[3],
                'order'      => $value[4],
                'paid'       => $value[5],
                'status'     => $value[6],
                'deleted'    => $value[7],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
    		];

    	}

    	Resources::insert($data);

    	echo 'Resources Collection Seeder Success!';

    }
}
