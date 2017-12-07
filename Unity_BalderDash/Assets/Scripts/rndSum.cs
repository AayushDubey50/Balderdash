using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class rndSum : MonoBehaviour {

    public Text time;
    private float tme;
    bool gmO;
    public Text scrs;
    public Text word;


    public GameObject def;
    public GameObject endGame;
    public GameObject rsm;
    public camSript jg;
    public Text rnd;

    // Use this for initialization
    void Start () {
        tme = 20;
        gmO = false;
       
        word.text = jg.getCurrWord();
        //StartCoroutine(resetRound());
        string scrt = "Scores: \n";
        for (int i = 0; i < jg.scores.Length; i++)
        {
            scrt += "\n" + jg.scores[i] + "\n";
        }
        scrs.text = scrt;
    }
	
	// Update is called once per frame
	void Update () {

        if(tme < 0)
        {
            tme = 0;
            nxtRnd();
        }
        else
        {
            tme -= Time.deltaTime;
        }
        int dtme = (int)tme;

        if(dtme == 10 )
        {
            StartCoroutine(resetRound());
            StartCoroutine(onStrt());
        }
        time.text = "Time: " + dtme + " s";

    }

    public IEnumerator resetRound()
    {
        //Debug.Log("reseround");
        WWWForm form = new WWWForm();
        form.AddField("functionName[]", "reset_round");
        form.AddField("functionName[]", jg.getID());
        form.AddField("functionName[]", jg.getGameID());
        
        //Debug.Log("Js1");
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php", form);
        //Debug.Log("JoinGame1.5");
        yield return www;
        //Debug.Log("JoinGame2");
        string wwwDataString = www.text;
    }

    public IEnumerator onStrt()
    {
        WWWForm form = new WWWForm();
        form.AddField("functionName[]", "onStart");
        form.AddField("functionName[]", jg.getUserID());
        form.AddField("functionName[]", jg.getGameID());
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php", form);
        yield return www;
        string wDataString = www.text;
        string[] splitString = wDataString.Split('\n');
        jg.currWord = splitString[0];
        Debug.Log("currWord: " + splitString[0]);
    }

    public IEnumerator crwrd()
    {
        //Debug.Log("Gid passed in: " + jg.getGameID());
        string lnk = "https://purduebalderdash.000webhostapp.com/php/getWord.php?gameID=" + jg.getGameID();
        //Debug.Log("linkgiven: " + lnk);
        WWW www = new WWW(lnk);
        yield return www;
        string wwwDataString = www.text;
        //Debug.Log("Word: " + wwwDataString);
        string wrd = wwwDataString;
        jg.currWord = wrd;
        word.text = jg.currWord;
    }

    public void nxtRnd()
    {
        //StartCoroutine(resetRound());
        GameObject curr = GameObject.FindGameObjectWithTag("rndSum");
        StartCoroutine(crwrd());
        tme = 10;
        if (jg.getRnd() == 5)
        {
            rsm.SetActive(false);
            endGame.SetActive(true);
        }
        else
        {
            jg.setRnd();
            int rm = jg.getRnd();
            //StartCoroutine(resetRound());
            rnd.text = "Round: " + rm + "/5";
            string scrt = "Scores: \n";
            for(int i = 0; i < jg.scores.Length;i++)
            {
                scrt += "\n" + jg.scores[i] + "\n";
            }
            scrs.text = scrt;
            scrs.text = jg.hardscores;
            rsm.SetActive(false);
            def.SetActive(true);
        }
            
    }
}
