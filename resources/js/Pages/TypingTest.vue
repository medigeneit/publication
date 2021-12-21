<template>
    <app-layout>
        <div class="w-full mx-auto max-w-4xl p-4">
            <div class="border rounded shadow p-4">
                <div
                    id="word-section"
                    class="flex flex-wrap text-xl"
                >
                    <div class="waiting">⌛</div>
                </div>

                <div id="type-section" class="mt-4 flex items-center gap-4">
                    <input
                        v-model="typedWord"
                        class="block w-full rounded text-3xl"
                        type="text"
                        tabindex="1"
                        autofocus
                        @keyup="typingTest"
                    />

                    <div class="text-center">
                        <span class="text-4xl font-bold">{{ timer }}</span>
                    </div>

                    <div class="text-center">
                        <button
                            class="border border-gray-700 px-3 py-1 rounded"
                            tabindex="2"
                            @click="restartTest"
                        >
                            <span id="restart-symbol">↻</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";

export default {
    components: {
        AppLayout,
    },
    data() {
        return {
            typedWord: "",
            submitted: false,
            wordData: {
                seconds: 60,
                correct: 0,
                incorrect: 0,
                total: 0,
                typed: 0,
            },
            timer: "1:00",
            wordList: [
                "the",
                "name",
                "of",
                "very",
                "to",
                "through",
                "and",
                "just",
                "a",
                "form",
                "in",
                "much",
                "is",
                "great",
                "it",
                "think",
                "you",
                "say",
                "that",
                "help",
                "he",
                "low",
                "was",
                "line",
                "for",
                "before",
                "on",
                "turn",
                "are",
                "cause",
                "with",
                "same",
                "as",
                "mean",
                "I",
                "differ",
                "his",
                "move",
                "they",
                "right",
                "be",
                "boy",
                "at",
                "old",
                "one",
                "too",
                "have",
                "does",
                "this",
                "tell",
                "from",
                "sentence",
                "or",
                "set",
                "had",
                "three",
                "by",
                "want",
                "hot",
                "air",
                "but",
                "well",
                "some",
                "also",
                "what",
                "play",
                "there",
                "small",
                "we",
                "end",
                "can",
                "put",
                "out",
                "home",
                "other",
                "read",
                "were",
                "hand",
                "all",
                "port",
                "your",
                "large",
                "when",
                "spell",
                "up",
                "add",
                "use",
                "even",
                "word",
                "land",
                "how",
                "here",
                "said",
                "must",
                "an",
                "big",
                "each",
                "high",
                "she",
                "such",
                "which",
                "follow",
                "do",
                "act",
                "their",
                "why",
                "time",
                "ask",
                "if",
                "men",
                "will",
                "change",
                "way",
                "went",
                "about",
                "light",
                "many",
                "kind",
                "then",
                "off",
                "them",
                "need",
                "would",
                "house",
                "write",
                "picture",
                "like",
                "try",
                "so",
                "us",
                "these",
                "again",
                "her",
                "animal",
                "long",
                "point",
                "make",
                "mother",
                "thing",
                "world",
                "see",
                "near",
                "him",
                "build",
                "two",
                "self",
                "has",
                "earth",
                "look",
                "father",
                "more",
                "head",
                "day",
                "stand",
                "could",
                "own",
                "go",
                "page",
                "come",
                "should",
                "did",
                "country",
                "my",
                "found",
                "sound",
                "answer",
                "no",
                "school",
                "most",
                "grow",
                "number",
                "study",
                "who",
                "still",
                "over",
                "learn",
                "know",
                "plant",
                "water",
                "cover",
                "than",
                "food",
                "call",
                "sun",
                "first",
                "four",
                "people",
                "thought",
                "may",
                "let",
                "down",
                "keep",
                "side",
                "eye",
                "been",
                "never",
                "now",
                "last",
                "find",
                "door",
                "any",
                "between",
                "new",
                "city",
                "work",
                "tree",
                "part",
                "cross",
                "take",
                "since",
                "get",
                "hard",
                "place",
                "start",
                "made",
                "might",
                "live",
                "story",
                "where",
                "saw",
                "after",
                "far",
                "back",
                "sea",
                "little",
                "draw",
                "only",
                "left",
                "round",
                "late",
                "man",
                "run",
                "year",
                "don't",
                "came",
                "while",
                "show",
                "press",
                "every",
                "close",
                "good",
                "night",
                "me",
                "real",
                "give",
                "life",
                "our",
                "few",
                "under",
                "stop",
                "open",
                "ten",
                "seem",
                "simple",
                "together",
                "several",
                "next",
                "vowel",
                "white",
                "toward",
                "children",
                "war",
                "begin",
                "lay",
                "got",
                "against",
                "walk",
                "pattern",
                "example",
                "slow",
                "ease",
                "center",
                "paper",
                "love",
                "often",
                "person",
                "always",
                "money",
                "music",
                "serve",
                "those",
                "appear",
                "both",
                "road",
                "mark",
                "map",
                "book",
                "science",
                "letter",
                "rule",
                "until",
                "govern",
                "mile",
                "pull",
                "river",
                "cold",
                "car",
                "notice",
                "feet",
                "voice",
                "care",
                "fall",
                "second",
                "power",
                "group",
                "town",
                "carry",
                "fine",
                "took",
                "certain",
                "rain",
                "fly",
                "eat",
                "unit",
                "room",
                "lead",
                "friend",
                "cry",
                "began",
                "dark",
                "idea",
                "machine",
                "fish",
                "note",
                "mountain",
                "wait",
                "north",
                "plan",
                "once",
                "figure",
                "base",
                "star",
                "hear",
                "box",
                "horse",
                "noun",
                "cut",
                "field",
                "sure",
                "rest",
                "watch",
                "correct",
                "color",
                "able",
                "face",
                "pound",
                "wood",
                "done",
                "main",
                "beauty",
                "enough",
                "drive",
                "plain",
                "stood",
                "girl",
                "contain",
                "usual",
                "front",
                "young",
                "teach",
                "ready",
                "week",
                "above",
                "final",
                "ever",
                "gave",
                "red",
                "green",
                "list",
                "oh",
                "though",
                "quick",
                "feel",
                "develop",
                "talk",
                "sleep",
                "bird",
                "warm",
                "soon",
                "free",
                "body",
                "minute",
                "dog",
                "strong",
                "family",
                "special",
                "direct",
                "mind",
                "pose",
                "behind",
                "leave",
                "clear",
                "song",
                "tail",
                "measure",
                "produce",
                "state",
                "fact",
                "product",
                "street",
                "black",
                "inch",
                "short",
                "lot",
                "numeral",
                "nothing",
                "class",
                "course",
                "wind",
                "stay",
                "question",
                "wheel",
                "happen",
                "full",
                "complete",
                "force",
                "ship",
                "blue",
                "area",
                "object",
                "half",
                "decide",
                "rock",
                "surface",
                "order",
                "deep",
                "fire",
                "moon",
                "south",
                "island",
                "problem",
                "foot",
                "piece",
                "yet",
                "told",
                "busy",
                "knew",
                "test",
                "pass",
                "record",
                "farm",
                "boat",
                "top",
                "common",
                "whole",
                "gold",
                "king",
                "possible",
                "size",
                "plane",
                "heard",
                "age",
                "best",
                "dry",
                "hour",
                "wonder",
                "better",
                "laugh",
                "true",
                "thousand",
                "during",
                "ago",
                "hundred",
                "ran",
                "am",
                "check",
                "remember",
                "game",
                "step",
                "shape",
                "early",
                "yes",
                "hold",
                "hot",
                "west",
                "miss",
                "ground",
                "brought",
                "interest",
                "heat",
                "reach",
                "snow",
                "fast",
                "bed",
                "five",
                "bring",
                "sing",
                "sit",
                "listen",
                "perhaps",
                "six",
                "fill",
                "table",
                "east",
                "travel",
                "weight",
                "less",
                "language",
                "morning",
                "among",
            ],
        };
    },
    computed: {},
    mounted() {
        this.addWords();
    },
    methods: {
        typingTest(event) {
            // Char:        Key Code:
            // <space>      32
            // <backspace>  8
            // <shift>      16
            // [A-Z]        65-90
            // [' "]        222
            event = event || window.event;
            let kCode = event.keyCode;
            if (this.typedWord.match(/^\s/g)) {
                this.typedWord = "";
                return false;
            }
            if (this.isTimer(this.wordData.seconds)) {
                this.checkWord(this.typedWord);
                if (kCode === 32) {
                    this.submitWord(this.typedWord);
                    this.clearLine();
                    this.typedWord = "";
                }

                if (this.wordData.typed > 100) {
                    let element = document.getElementById("word-section");
                    let currentScroll = element.scrollTop;
                    element.scrollTop = currentScroll + 20;
                }
            } else {
                this.calculateWPM();
            }
        },
        isTimer(seconds) {
            let time = seconds;
            let one = this.timer;
            if (this.timer === "1:00") {
                let typingTimer = setInterval(() => {
                    if (time <= 0) {
                        clearInterval(typingTimer);
                    } else {
                        time -= 1;
                        let timePad = time < 10 ? "0" + time : time;
                        this.timer = `0:${timePad}`;
                    }
                }, 1000);
            }
            return one !== "0:00";
        },
        addWords() {
            let wordSection = document.getElementById("word-section");
            this.typedWord = "";
            wordSection.innerHTML = "";
            for (let i = 200; i > 0; i--) {
                let words = this.shuffle(this.wordList);
                let wordSpan = `<span class="px-1">${words[i]}</span>`;
                wordSection.innerHTML += wordSpan;
            }
            wordSection.firstChild.classList.add("current-word");
        },
        checkWord(word) {
            let wordLength = word.length;
            let current = document.getElementsByClassName("current-word")[0];
            let currentSubstring = current.innerHTML.substring(0, wordLength);
            if (word.trim() === currentSubstring && wordLength) {
                current.classList.remove("incorrect-word-bg");
                return true;
            }

            current.classList.add("incorrect-word-bg");
            return false;
        },
        shuffle(array) {
            let m = array.length,
                t,
                i;
            while (m) {
                i = Math.floor(Math.random() * m--);
                t = array[m];
                array[m] = array[i];
                array[i] = t;
            }
            return array;
        },
        submitWord(word) {
            let current = document.getElementsByClassName("current-word")[0];
            if (this.checkWord(word)) {
                current.classList.remove("current-word");
                current.classList.add("correct-word-c");
                this.wordData.typed += word.length;
                this.wordData.correct += 1;
            } else {
                current.classList.remove("current-word", "incorrect-word-bg");
                current.classList.add("incorrect-word-c");
                this.wordData.incorrect += 1;
            }
            this.wordData.total =
                this.wordData.correct + this.wordData.incorrect;

            current.nextSibling.classList.add("current-word");
        },
        clearLine() {
            let wordSection = document.getElementById("word-section");
            let current = document.getElementsByClassName("current-word")[0];
            let previous = current.previousSibling;
            let children = document.querySelectorAll(
                ".correct-word-c, .incorrect-word-c"
            )[0].length;
            if (current.offsetTop > previous.offsetTop) {
                for (let i = 0; i < children; i++) {
                    wordSection.removeChild(wordSection.firstChild);
                }
            }
        },
        calculateWPM() {
            let { seconds, correct, incorrect, total, typed } = this.wordData;
            let minutes = seconds / 60;
            let wpm = Math.ceil((typed / 5 - incorrect) / minutes);
            let accuracy = Math.ceil((correct / total) * 100);
            if (wpm < 0) {
                wpm = 0;
            }
            document.getElementById(
                "word-section"
            ).innerHTML = `<ul id="results">
                    <li>WPM: <span class="wpm-value">${wpm}</span></li>
                    <li>Accuracy: <span class="wpm-accuracy">${accuracy}%</span></li>
                    <li>Total Words: <span>${total}</span></li>
                    <li>Correct Words: <span>${correct}</span></li>
                    <li>Incorrect Words: <span>${incorrect}</span></li>
                    <li>Characters Typed: <span>${typed}</span></li>
                </ul>`;
            let wpmClass =
                document.getElementsByClassName("wpm-accuracy")[0].classList;
            if (accuracy > 80) {
                wpmClass.add("correct-word-c");
            } else {
                wpmClass.add("incorrect-word-c");
            }
            if (!this.submitted) {
                window.axios
                    .post("/submit-test", {
                        words_per_minute: wpm,
                        accuracy: accuracy,
                        total_words: total,
                        correct_words: correct,
                        incorrect_words: incorrect,
                        characters_typed: typed,
                    })
                    .then((response) => {
                        console.log(response);
                        this.submitted = true;
                    })
                    .catch((response) => {
                        console.log(response);
                    });
            }
        },
        restartTest() {
            this.typedWord = "";
            location.reload();
        },
    },
};
</script>
