using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class wordDef : MonoBehaviour {

    public Text timer;
    public Text Rnd;
    public Button d1;
    public Button d2;
    public Button d3;
    public Button d4;
    public Button d5;
    public Button d6;
    public string wrd;
    public string def;
    public string totdef;
    public string[] defs;
    public Text currSore;
    public Text currWrd;
    public InputField defsub;
    public Button submit;
    private float t1;
    private float t2;

    public GameObject defSelect;
    public camSript jg;
    float time;

	// Use this for initialization
	void Start () {
        time = 30;
        int len = jg.Pnum();
        StartCoroutine(crwrd());
        string scres = "Scores:\n\n";
        for(int i = 1; i <= len; i++)
        {
            scres += jg.p[i] + ": 0\n\n" ;
        }
        t1 = 0;
        t2 = 0;
        currWrd.text = jg.currWord;
        currSore.text = scres;
        //int rnd = jg.getRnd();
        //Rnd.text = "Round: " + rnd + "/10";
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
        wrd = wwwDataString;
        jg.currWord = wrd;
        currWrd.text = jg.currWord;
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

    public IEnumerator onChoices()
    {
        WWWForm form = new WWWForm();
        form.AddField("functionName[]", "onChoices");
        form.AddField("functionName[]", jg.getUserID());
        form.AddField("functionName[]", jg.getGameID());
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php", form);
        yield return www;
        string wDataString = www.text;
    }
    // Update is called once per frame
    void Update ()
    {
        time -= Time.deltaTime;
        if(time < 0)
        {
            time = 0;
            defselect();
        }

        
        int rtme = (int)time;
        timer.text = "Time: " + rtme + " s";
        t1 += Time.deltaTime;
        if(t1 - t2 >= 2)
        {
            if (jg.currWord.Equals(""))
            {
                StartCoroutine(crwrd());
                //currWrd.text = jg.currWord;
                time = 30;

            }
            t2 = t1;
        }

        if(time >= 2 && time < 3)
            StartCoroutine(crwrd());

    }

    public void submitDef()
    {
        def = defsub.text;
        StartCoroutine(subdef());
        submit.GetComponent<Button>().interactable = false;

    }

    public void getDefs()
    {
        StartCoroutine(retDefs());
        d1.GetComponentInChildren<Text>().text = defs[0];
        d2.GetComponentInChildren<Text>().text = defs[1];
        d3.GetComponentInChildren<Text>().text = defs[2];
        d4.GetComponentInChildren<Text>().text = defs[3];
        if (jg.pnum >= 4)
            d5.GetComponentInChildren<Text>().text = defs[4];
        else
            d5.gameObject.SetActive(false);
        if (jg.pnum >= 5)
            d6.GetComponentInChildren<Text>().text = defs[5];
        else
            d6.gameObject.SetActive(false);


    }

    public IEnumerator retDefs()
    {
        Debug.Log("Gid passed in: " + jg.getGameID());
        string lnk = "https://purduebalderdash.000webhostapp.com/php/getDefinitions.php?gameID=" + jg.getGameID();
        Debug.Log("linkgiven: " + lnk);
        WWW www = new WWW(lnk);
        yield return www;
        string wwwDataString = www.text;
        Debug.Log("defs: " + wwwDataString);
        totdef = wwwDataString;
        defs = wwwDataString.Split('\n');
    }

    public IEnumerator subdef()
    {
        Debug.Log("submitdef");
        WWWForm form = new WWWForm();
        form.AddField("functionName[]", "input_definition");
        form.AddField("functionName[]", jg.getID());
        form.AddField("functionName[]", jg.getGameID());
        form.AddField("functionName[]", def);
        Debug.Log("JoinGame1");
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php", form);
        //Debug.Log("JoinGame1.5");
        yield return www;
        //Debug.Log("JoinGame2");
        string wwwDataString = www.text;
        //Debug.Log("GID set = " + wwwDataString);
        //cs.setGameID(wwwDataString);
        //Debug.Log("JoinGame3");
        //yield return www;
        //txt.text = wwwDataString;
    }


    void defselect()
    {
        getDefs();
        StartCoroutine(onChoices());
        int rnd = jg.getRnd();
        Rnd.text = "Round: " + rnd + "/5";
        GameObject wdf = GameObject.FindGameObjectWithTag("wordDef");
        time = 30;
        wdf.SetActive(false);
        //d5.gameObject.SetActive(true);
        //d6.gameObject.SetActive(true);
        submit.GetComponent<Button>().interactable = true;
        defSelect.SetActive(true);
    }
}
