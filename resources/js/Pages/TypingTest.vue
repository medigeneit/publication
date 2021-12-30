<template>
    <app-layout>
        <div class="w-full mx-auto max-w-4xl p-4">
            <div class="border rounded shadow p-4">
                <ul v-if="result.status">
                    <li>
                        WPM: <span class="wpm-value">{{ result.wpm }}</span>
                    </li>
                    <li>
                        Accuracy:
                        <span class="wpm-accuracy">{{ result.accuracy }}%</span>
                    </li>
                    <li>
                        Total Words: <span>{{ result.totalWord }}</span>
                    </li>
                    <li>
                        Correct Words: <span>{{ result.correctWord }}</span>
                    </li>
                    <li>
                        Incorrect Words: <span>{{ result.incorrectWord }}</span>
                    </li>
                    <li>
                        Characters Typed:
                        <span>{{ result.characerTyped }}</span>
                    </li>
                </ul>

                <div v-if="!result.status" class="flex flex-wrap text-xl">
                    <span
                        v-for="(word, index) in words"
                        :key="index"
                        class="px-1"
                        :class="word.classes[word.status]"
                    >
                        {{ word.text }}
                    </span>
                    <div v-if="!words.length" class="w-full text-center">
                        <div class="inline-block animate-spin">⌛</div>
                    </div>
                </div>

                <div class="flex justify-between items-center gap-4 mt-4">
                    <input
                        v-if="!result.status"
                        v-model="typedWord"
                        class="block w-full rounded text-3xl"
                        type="text"
                        tabindex="1"
                        autofocus
                        @keyup="typingTest"
                    />

                    <div v-if="!result.status" class="text-center">
                        <span v-if="timer">{{ timer }}</span>
                        <select v-else v-model="wordData.seconds">
                            <option value="60">1 minute</option>
                            <option value="120">2 minutes</option>
                            <option value="300">5 minutes</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button
                            class="border border-gray-700 px-3 py-2"
                            tabindex="2"
                            @click="restartTest"
                        >
                            <span>↻</span>
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
            wordData: {
                seconds: 60,
                correct: 0,
                incorrect: 0,
                total: 0,
                typed: 0,
            },
            timer: "",
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
            words: [],
            result: {
                wpm: 0,
                accuracy: 0,
                totalWord: 0,
                correctWord: 0,
                incorrectWord: 0,
                characerTyped: 0,
                status: false,
            },
        };
    },
    computed: {},
    mounted() {
        this.addWords(30, true);
    },
    methods: {
        addWords(count = 10, init = false) {
            for (let i = count; i > 0; i--) {
                this.words.push({
                    text: this.wordList[
                        Math.floor(Math.random() * this.wordList.length)
                    ], //random text from wordList
                    status: init && count == i ? 1 : 0,
                    classes: {
                        0: "", //normal word
                        1: "bg-gray-300 rounded", //current word
                        2: "bg-red-400", //current wrong typing
                        3: "text-green-600", //correct word
                        4: "text-red-600", //incorrect word
                    },
                });
            }
        },
        removeWords(count = 10) {
            let total = Math.min(count, this.words.length);

            for (let i = total; i > 0; i--) {
                this.words.shift();
            }

            return total;
        },
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
                let response = this.checkWord(this.typedWord);

                if (kCode === 32) {
                    this.submitWord(this.typedWord, response);
                    this.typedWord = "";
                }

                return;

                if (this.wordData.typed > 100) {
                    let element = document.getElementById("word-section");
                    let currentScroll = element.scrollTop;
                    element.scrollTop = currentScroll + 20;
                }
            } else {
                this.calculateWPM();
            }
        },
        findCurrentWord() {
            return this.words.find(
                (word) => word.status === 1 || word.status === 2
            );
        },
        checkWord(word) {
            let current = this.findCurrentWord();

            if (word.trim() !== current.text.slice(0, word.length)) {
                current.status = 2;
                return false;
            }

            current.status = 1;
            return true;
        },
        submitWord(word, response) {
            let current = this.findCurrentWord();

            if (response) {
                current.status = 3;
                this.wordData.typed += word.length;
                this.wordData.correct += 1;
            } else {
                current.status = 4;
                this.wordData.incorrect += 1;
            }

            this.wordData.total =
                this.wordData.correct + this.wordData.incorrect;

            let index = this.words.indexOf(current);

            if (index + 2 > this.words.length) {
                index = index - this.removeWords(this.words.length);
                this.addWords(this.words.length);
            }

            this.words[index + 1].status = 1;
        },
        calculateWPM() {
            let { seconds, correct, incorrect, total, typed } = this.wordData;
            let minutes = seconds / 60;
            let wpm = Math.ceil((typed / 5 - incorrect) / minutes);
            let accuracy = Math.ceil((correct / total) * 100);

            this.result.wpm = wpm > 0 ? wpm : 0;
            this.result.accuracy = accuracy;
            this.result.correctWord = correct;
            this.result.incorrectWord = incorrect;
            this.result.characerTyped = typed;
            this.result.totalWord = correct + incorrect;

            this.result.status = true;
        },
        isTimer(totalSeconds) {
            let typingTimer = setInterval(() => {
                if (totalSeconds <= 0) {
                    clearInterval(typingTimer);
                    this.calculateWPM();
                } else {
                    totalSeconds -= 1;

                    let seconds = totalSeconds % 60;

                    let minutes = totalSeconds / 60;

                    this.timer = `${minutes}:${minutes}`;
                }
            }, 1000);
        },
        restartTest() {
            this.typedWord = "";
            location.reload();
        },
    },
};
</script>
