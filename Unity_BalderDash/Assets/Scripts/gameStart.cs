using UnityEngine;
using UnityEngine.UI;
using System.Collections;
using System;

public class gameStart : MonoBehaviour {

    public Text cntdwntxt;
    public GameObject dword;
    public GameObject brd;
    public GameObject ss;
    private String[] totstr;
    public bool starttime;
    public Text currNames;
    public camSript camS;
    private float time;
    private string bll;
    private int tsum;
    private float tme;
    private float prevtme;
    private string prevret;
    private float tmecall;
    private string gid;
	// Use this for initialization
	void Start ()
    {
        GameObject bHome = GameObject.FindGameObjectWithTag("board");
        brd.SetActive(false);
        GameObject sScreen = GameObject.FindGameObjectWithTag("StartScreen");

        ss.SetActive(false);
        time = 20;
        tsum = 0;
        starttime = false;
        tmecall = 0;
        prevtme = 0;
        bll = "gs";
        prevret = "strt";
        StartCoroutine(getGameID());
	}


    public IEnumerator getGameID()
    {
        //Debug.Log("id passed in: " + camS.getID());
        string lnk = "https://purduebalderdash.000webhostapp.com/php/getGameID.php?userID=" + camS.getID();

        //Debug.Log("linkgiven: " + lnk);
        WWW www = new WWW(lnk);
        yield return www;
        string wwwDataString = www.text;
        //Debug.Log("GameID: " + wwwDataString);
        camS.gameID = wwwDataString;

    }


    // Update is called once per frame
    void Update ()
    {
        tmecall += Time.deltaTime;
        //int tcall = (int)time;
        int sec = 0;
        if(tmecall - prevtme >= 1)
        {
            StartCoroutine(getNames());
            prevtme = tmecall;
            sec = 1;
        }

        //Debug.Log("bll: " + bll);
        //Debug.Log("boolean value: " + starttime);

        if (bll == "True")
        {
            starttime = true;
            //Debug.Log("its true now");
        }
        else
        {
            starttime = false;
        }
            //getNames();
        //tme += Time.deltaTime;
        //getbool 
        if(time > 0 && starttime)
            time -= sec;
        else if(time <= 0 || camS.getPnum() >= 5)
        {
            time = 0;
            playGame();
        }
        int dtme = (int)time;
        //Debug.Log(dtme.ToString());
        //Debug.Log(Time.deltaTime);
        cntdwntxt.text = "Time For Game to Start: " + dtme + " s";
        //getusernames
	}

    void playGame()
    {
        //Debug.Log("pg1");
        camS.p = totstr;
        StartCoroutine(onStrt());
        //Debug.Log("pg2");
        for (int i = 1; i < totstr.Length; i++)
        {
            if(camS.getP1() == "")
            {
                camS.setP1(totstr[i]);
            }
            if (camS.getP2() == "")
            {
                camS.setP2(totstr[i]);
            }
            if (camS.getP3() == "")
            {
                camS.setP3(totstr[i]);
            }
            if (camS.getP4() == "")
            {
                camS.setP4(totstr[i]);
            }
            if (camS.getP5() == "")
            {
                camS.setP5(totstr[i]);
            }
        }

        camS.setPnum(totstr.Length-1);


        GameObject ws = GameObject.FindGameObjectWithTag("waitScreen");
        time = 30;
        ws.SetActive(false);
        dword.SetActive(true);
    }

    public IEnumerator onStrt()
    {
        //Debug.Log("onstart1");
        WWWForm form = new WWWForm();
        form.AddField("functionName[]", "onStart");
        form.AddField("functionName[]", camS.getUserID());
        form.AddField("functionName[]", camS.getGameID());
        //Debug.Log("onstartchck");
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php", form);
        prevtme = tme;
        examp();
        //Debug.Log("onstartafterdelay");
        yield return www;
        //Debug.Log("onstart2");
        string wDataString = www.text;
        string[] splitString = wDataString.Split('\n');
        //Debug.Log("input: " + wDataString);
        //camS.currWord = splitString[0];
        //Debug.Log("currWord: " + splitString[0]);
    }

    IEnumerator Example()
    {
        print(Time.time);
        yield return new WaitForSeconds(10);
        print(Time.time);
    }

    void examp()
    {
        tme += Time.deltaTime;
           
    }

    public IEnumerator getNames()
    {
        StartCoroutine(getGameID());
        WWWForm form = new WWWForm();
        //Debug.Log("gid passed: " + camS.getGameID());
        form.AddField("callStage", camS.getGameID());
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameStage.php", form);
        yield return www;
        string wDataString = www.text;
        string[] splitString = wDataString.Split('\n');
        bll = splitString[0];
        //Debug.Log("split1: " + splitString[0]);
        string tot = "";
        //Debug.Log("given: " + wDataString);
        for (int i = 1; i < splitString.Length; i++)
        {
            tot += splitString[i] + "\n";
        }
        camS.setPnum(splitString.Length-1);
        //Debug.Log("og split:" + splitString[0] + "\n" + tot);
        //Debug.Log("split2: " + tot);
        currNames.text = tot;
        if (!tot.Equals(prevret) && !prevret.Equals("strt") && starttime)
        {
            time = 20;
        }
        //Debug.Log("data: " + wDataString);
        prevret = tot;
        totstr = splitString;
    }

    public IEnumerator getBool()
    {
        WWWForm form = new WWWForm();
        form.AddField("callStage", "getUserNames");
        WWW www = new WWW("https://purduebalderdash.000webhostapp.com/php/gameStage.php", form);
        yield return www;
        string wDataString = www.text;
        currNames.text = wDataString;
        //Debug.Log(wDataString);
    }
}
