# PropertyFinder dev test

Please find out [TASK.md](./TASK.md) to read the task and requirements.

### Project Structure:
- `App\Model\BoardingCard` boarding card model.
- `App\Model\TransportationType` holds different types of transportation (as enum).
- `App\Service\BoardingService` business logic for sorting and managing boarding cards.
- `App\Test\BoardingServiceTest` some unit tests to cover BoardingService.
- `App\Application` application starter which also runs and prints default example.
- `index.php` to call application starter by `App\Application::init();`
There are also different type of exceptions or classes there which you maybe interested to checkout.

Business logic for managing BoardingCards has been implemented in BoardingService which implements IBoardingService.
You can use `IBoardingService` API for other usages.

### Sorting solution:
All sorting logic has been implemented in BoardingService. There is a `chains` array there which holds sub chains.
<br />
Each chain by it self is an array of BoardingCard.

Let's assume that we have a list of boarding cards in correct order of :
<br />
`[AA(from: null, to: BB), BB(from: AA, to: CC), CC(from: BB, to: DD), DD(from: CC, to: EE), EE(from: DD, to: null)]`.
<br />
We'll shuffle the list to have a random list like: `[BB, CC, EE, DD, AA]`

First insert will result `chains` to be like `[[BB]]`, means we create a new chain into our chains list.
<br />
Whenever another new BoardingCard is added, we check beginning and end of 
our chains to see if `from` and `to` properties can fit there: 
1. if fits we add the boardingCard to the beginning or end 
of the existing chain:
<br />
By adding `CC` our chains list will be like: `[[BB, CC]]`
2. if not fits, we add a new chain to our chains list:
<br />
By adding `EE`, we realize that it does not fit at the end or beginning of our only one existing chain. so we create 
new one and our chains list will be like: `[[BB, CC], [EE]]`.

Adding `DD` will result in `[[BB, CC, DD], [EE]]` and `AA` will result in `[[AA, BB, CC, DD], [EE]]`.
<br />
Now the last step which is executed only when you call `BoardingService.getChain()` method, is to merge all existing chains.
<br />
We select First chain as base and check all other chains to see if it fits the beginning or end of our chain. If it fits
We merge and remove it from the list. We do this step until all chains got merged.

On each loop if we cannot find another proper chain to merge but there are some existing ones there, it means we have a 
broken chain and our service will throws a `BoardingServiceBrokenChainException`.


<br />

#### @AUTHOR
Pezhman Jahanmard
<br />
pezhman32@gmail.com
<br />
Skype: pezhman128