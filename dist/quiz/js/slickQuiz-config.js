// Setup your quiz text and questions here

// NOTE: pay attention to commas, IE struggles with those bad boys

var quizJSON = {
    "info": {
        "name":    "Prova de Power Center - Nível Pleno",
        "main":    "<p>Prove que você está apto a exercer a função!</p>",
        "results": "<h3>Informativo</h3><h4><p>Os dados obtidos na avaliação, serão enviados por e-mail para a Empresa/HeadHunter responsável. Para maiores informações, entre em contato com a pessoa responsável pelo seu processo seletivo. Esta avaliação não determina se você irá ou não obter o cargo que está concorrendo.</p></h4>",
        "level1":  "De 81% a 100% de acertividade",
        "level2":  "De 61% a 80% de acertividade",
        "level3":  "De 41% a 60% de acertividade",
        "level4":  "De 21% a 40% de acertividade",
        "level5":  "De 0% a 20% de acertividade" // no comma here
    },
    "questions": [
        { // Question 1 - Multiple Choice, Single True Answer
            "q": "01 - No Power Center, onde é alterado a senha do usuário?",
            "a": [
				{"option": "WorkFlow",   "correct": false},
				{"option": "Designer",   "correct": false},
				{"option": "Repository", "correct": true},
				{"option": "Monitor",    "correct": false},
				{"option": "Nenhuma das alternativas", "correct": false} // no comma here					
            ],
            "correct": "<p><span>That's right!</span> The letter A is the first letter in the alphabet!</p>",
            "incorrect": "<p><span>Uhh no.</span> It's the first letter of the alphabet. Did you actually <em>go</em> to kindergarden?</p>" // no comma here
        },
        { // Question 2 - Multiple Choice, Multiple True Answers, Select Any
            "q": "02 - Em qual aplicativo é feito as configurações do mapas do Power Center?",
            "a": [
				{"option": "WorkFlow",      "correct": true},
				{"option": "PowerExchange",     "correct": false},
				{"option": "Data Transformation",      "correct": false},
				{"option": "Monitor",     "correct": false},
				{"option": "Nenhuma das alternativas", "correct": false} // no comma here				
            ],
            "correct": "<p><span>Nice!</span> Your cholestoral level is probably doing alright.</p>",
            "incorrect": "<p><span>Hmmm.</span> You might want to reconsider your options.</p>" // no comma here
        },
        { // Question 3 - Multiple Choice, Multiple True Answers, Select All
            "q": "03 - Segundo os padrões de boas práticas da Informatica, selecione a melhor resposta?",
            "a": [
				{"option": "Incluir o componente Joiner sem checar a opção Sorted Input",      "correct": false},
				{"option": "Não utilizar o Source Qualifier e efetuar todos os Joins com o componente Joiner",     "correct": false},
				{"option": "Incluir Lookup somente quando necessário",      "correct": true},
				{"option": "Incluir Lookup ao inves de Joiner para todos os casos",     "correct": false},
				{"option": "Nenhuma das alternativas", "correct": false} // no comma here
            ],
			//"select_any": true,
            "correct": "<p><span>Brilliant!</span> You're seriously a genius, (wo)man.</p>",
            "incorrect": "<p><span>Not Quite.</span> You're actually on Planet Earth, in The Milky Way, At a computer. But nice try.</p>" // no comma here
        },
        { // Question 4
            "q": "04 - Onde é feito o detalhamento do processo de carga do Power Center?",
            "a": [
				{"option": "Register",      "correct": false},
				{"option": "Source Definition",     "correct": false},
				{"option": "Session",      "correct": false},
				{"option": "Monitor",     "correct": true},
				{"option": "Nenhuma das alternativas", "correct": false} // no comma here
            ],
            "correct": "<p><span>Holy bananas!</span> I didn't actually expect you to know that! Correct!</p>",
            "incorrect": "<p><span>Fail.</span> Sorry. You lose. It actually rains approximately 32 inches a year in Michigan.</p>" // no comma here
        },
        { // Question 5
            "q": "05 - Qual função é utilzada para fazer pesquisas?",
            "a": [
				{"option": "LTRIM",      "correct": false},
				{"option": "RTRIM",     "correct": false},
				{"option": "Lookup",      "correct": true},
				{"option": "DECODE",     "correct": false},
				{"option": "Nenhuma das alternativas", "correct": false} // no comma here
            ],
            "correct": "<p><span>Good Job!</span> You must be very observant!</p>",
            "incorrect": "<p><span>ERRRR!</span> What planet Earth are <em>you</em> living on?!?</p>" // no comma here
        },
        { // Question 6
            "q": "06 - Onde encontramos a opção Suspend on Error?",
            "a": [
				{"option": "WorkFlow",      "correct": true},
				{"option": "Session",     "correct": false},
				{"option": "Mapping",      "correct": false},
				{"option": "Folder",     "correct": false},
				{"option": "Nenhuma das alternativas", "correct": false} // no comma here
            ],
            "correct": "<p><span>Good Job!</span> You must be very observant!</p>",
            "incorrect": "<p><span>ERRRR!</span> What planet Earth are <em>you</em> living on?!?</p>" // no comma here
        },
        { // Question 7
            "q": "07 - Qual objeto é responsável por unir o fluxo de dados em um mapa?",
            "a": [
				{"option": "Joiner",      "correct": false},
				{"option": "Aggregator",     "correct": false},
				{"option": "Union",      "correct": true},
				{"option": "Lookup",     "correct": false},
				{"option": "Nenhuma das alternativas", "correct": false} // no comma here
            ],
            "correct": "<p><span>Good Job!</span> You must be very observant!</p>",
            "incorrect": "<p><span>ERRRR!</span> What planet Earth are <em>you</em> living on?!?</p>" // no comma here
        },
        { // Question 8
            "q": "08 - Como funciona a função MID no Power Center?",
            "a": [
				{"option": "Inserindo valores numéricos e efetuando a pesquisa",      "correct": false},
				{"option": "Inserindo valores alfanumericos e efetuando a pesquisa",     "correct": false},
				{"option": "Inserindo apenas caracteres especiais e efetuando a pesquisa",      "correct": false},
				{"option": "Inserindo datatypes da Expression e efetuando a pesquisa",     "correct": false},
				{"option": "Nenhuma das alternativas", "correct": true} // no comma here
            ],
            "correct": "<p><span>Good Job!</span> You must be very observant!</p>",
            "incorrect": "<p><span>ERRRR!</span> What planet Earth are <em>you</em> living on?!?</p>" // no comma here
        },
        { // Question 9
            "q": "09 - Qual a diferença de Lookup desconectada e Lookup conectada?",
            "a": [
				{"option": "Lookup desconectada efetua a pesquisa para apenas um registro e a conectada para vários registros",      "correct": true},
				{"option": "Lookup conectada efetua a pesquisa para apenas um registro e a desconectada para vários registros",     "correct": false},
				{"option": "Lookup desconectada efetua a pesquisa e tras apenas 1 porta como resultado e a conectada trás várias portas",      "correct": true},
				{"option": "Lookup conectada efetua a pesquisa e tras apenas 1 porta como resultado e a desconectada trás várias portas",     "correct": false},
				{"option": "Nenhuma das alternativas", "correct": false} // no comma here
            ],
            "correct": "<p><span>Good Job!</span> You must be very observant!</p>",
            "incorrect": "<p><span>ERRRR!</span> What planet Earth are <em>you</em> living on?!?</p>" // no comma here
        },
        { // Question 10
            "q": "10 - Qual é a opção para ordernar o fluxo de carga de Targets em um mapa?",
            "a": [
				{"option": "Macth Targets",      "correct": false},
				{"option": "First Targets",     "correct": false},
				{"option": "Include Targets",      "correct": false},
				{"option": "Target Load Plan",     "correct": true},
				{"option": "Nenhuma das alternativas", "correct": false} // no comma here
            ],
            "correct": "<p><span>Good Job!</span> You must be very observant!</p>",
            "incorrect": "<p><span>ERRRR!</span> What planet Earth are <em>you</em> living on?!?</p>" // no comma here
        }// no comma here
    ]
};
